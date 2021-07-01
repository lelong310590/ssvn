<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 4:52 PM
 */

namespace Users\Models;

use Advertise\Models\Advertise;
use Advertise\Models\AdvertiseUser;
use Cart\Models\OrderDetail;
use ClassLevel\Models\ClassLevel;
use Course\Models\Course;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Messages\Models\MessageLists;
use Messages\Models\Messages;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Users extends Authenticatable
{
    use EntrustUserTrait;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username', 'email', 'password', 'thumbnail', 'first_name', 'last_name', 'phone', 'status', 'sex', 'created_at', 'updated_at', 'sold_course',
        'classlevel', 'is_enterprise'
    ];

    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = str_slug($value, '_');
    }

    //Big block of caching functionality.
    public function cachedRoles()
    {
        $userPrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_roles_for_user_' . $this->$userPrimaryKey;
        return Cache::tags(Config::get('acl.role_user_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->roles()->get();
        });
    }

    public function save(array $options = [])
    {   //both inserts and updates
        $result = parent::save($options);
        Cache::tags(Config::get('acl.role_user_table'))->flush();
        return $result;
    }

    public function delete(array $options = [])
    {   //soft or hard
        $result = parent::delete($options);
        Cache::tags(Config::get('acl.role_user_table'))->flush();
        return $result;
    }

    public function restore()
    {   //soft delete undo's
        $result = parent::restore();
        Cache::tags(Config::get('acl.role_user_table'))->flush();
        return $result;
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Config::get('acl.role'), Config::get('acl.role_user_table'), Config::get('acl.user_foreign_key'), Config::get('acl.role_foreign_key'));
    }

    /**
     * Get role name
     * @return null
     */
    public function getRole()
    {
        $roles = $this->roles()->first();
        if (!empty($roles)) {
            return $roles->display_name;
        } else {
            return null;
        }
    }

    /**
     * Relation 1 - n with meta data
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function data()
    {
        return $this->hasMany(UsersMeta::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class, 'author');
    }

    public function sell()
    {
        return $this->hasMany(OrderDetail::class, 'author');
    }

    public function bought()
    {
        return $this->hasMany(OrderDetail::class, 'customer');
    }

    public function messages()
    {
        return $this->hasMany(MessageLists::class, 'user_id');
    }

    public function getAdvertise()
    {
        return $this->belongsToMany(Advertise::class, (new AdvertiseUser())->getTable(), 'user_id', 'advertise_id');
    }

    public function boughtSuccess()
    {
        return $this->bought->where('status', 'done')->load('course');
    }

    public function getStatusByKey($key)
    {
        return $this->data->where('meta_key', $key)->first() ? $this->data->where('meta_key', $key)->first()->status : null;
    }

    public function getDataByKey($key)
    {
        $data = $this->data->where('meta_key', $key)->first() ? $this->data->where('meta_key', $key)->first()->meta_value : null;
        return \config('meta.' . $key . '.' . $data) != null ? \config('meta.' . $key . '.' . $data) : $data;
    }

    public function getDataRawByKey($key)
    {
        $data = $this->data->where('meta_key', $key)->first() ? $this->data->where('meta_key', $key)->first()->meta_value : null;
        return $data;
    }

    public function getTextDataByKey($key)
    {
        return \config('meta.' . $key . '.' . $this->getDataByKey($key));
    }

    public function getPositionAttribute($value)
    {
        return \config('meta.position.' . $value) != null ? \config('meta.position.' . $value) : $value;
    }

    public function getAverageRating()
    {
        $avg = 0;
        $total = 0;
        foreach ($this->course as $course) {
            if ($course->getAverageRating() > 0) {
                $avg += $course->getAverageRating();
                $total++;
            }
        }
        return $total == 0 ? $total : floor($avg / $total * 2) / 2;
    }

    public function getTotalStudent()
    {
        return $this->sell()->distinct('customer')->count('customer');
    }

    public function getExam()
    {
        return $this->belongsToMany(Course::class,'exam_user', 'user_id', 'exam_id');
    }

    public function checkDoExam($course_id)
    {
        $exam = $this->getExam()->where('exam_id', $course_id)->get();
        $check = $exam->isNotEmpty() ? true : false;
        return $check;
    }

    public function getClassLevel()
    {
        return $this->hasOne(ClassLevel::class, 'classlevel', 'id');
    }

}