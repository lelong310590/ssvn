<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Course\Models;

use Advertise\Models\Advertise;
use Cart\Models\OrderDetail;
use ClassLevel\Models\ClassLevel;
use Coupon\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Rating\Models\Rating;
use Subject\Models\Subject;
use Users\Models\Users;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = 'course';
    protected $guarded = [];
    protected $fillable = [
        'name', 'slug', 'author', 'editor', 'status', 'created_at', 'updated_at', 'published_at', 'price',
        'approve_sale_system', 'type', 'google_analytics_id', 'assistant', 'time_start', 'time_end'
    ];

    /**
     * Convert string timestrap to Carbon obj
     * @param $value
     */
    public function setPublishedAtAttribute($value)
    {
        $published_at = strtotime(str_replace('/', '-', $value));
        $published_at = Carbon::createFromTimestamp($published_at);
        $this->attributes['published_at'] = $published_at;
    }

    public function setTimeStartAttribute($value)
    {
        $published_at = strtotime(str_replace('/', '-', $value));
        $published_at = Carbon::createFromTimestamp($published_at);
        $this->attributes['time_start'] = $published_at;
    }

    public function setTimeEndAttribute($value)
    {
        $published_at = strtotime(str_replace('/', '-', $value));
        $published_at = Carbon::createFromTimestamp($published_at);
        $this->attributes['time_end'] = $published_at;
    }

//    public function getUpdatedAtAttribute($value)
//    {
//        return date('H:i d/m/Y', strtotime($value));
//    }

    public function checkSaleAvailable()
    {
        if ($this->approve_sale_system == 'active' && !empty(app('sale_system'))) {
            $sale_course = app('sale_system')->where('min_price', '<=', $this->getOriginal('price'))->where('max_price', '>=', $this->getOriginal('price'))->first();
            if (!empty($sale_course)) {
                return true;
            }
        }
        return false;
    }

    public function getPriceAttribute($value)
    {
        if ($this->approve_sale_system == 'active' && !empty(app('sale_system'))) {
            $sale_course = app('sale_system')->where('min_price', '<=', $value)->where('max_price', '>=', $value)->first();
            if (!empty($sale_course)) {
                return $sale_course->price;
            }
        }
        return $value;
    }

    function checkCoupon($coupon)
    {
        $coupon = Coupon::where('code', $coupon)
            ->where('deadline', '>', date('Y-m-d H:i:s'))
            ->where('reamain', '>', 0)
            ->where('course', $this->id)
            ->first();
        return $coupon;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Users::class, 'author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function edit()
    {
        return $this->belongsTo(Users::class, 'editor');
    }

    public function getLdp()
    {
        return $this->hasOne(CourseLdp::class, 'course_id', 'id');
    }

    public function getTarget()
    {
        return $this->hasOne(CourseTarget::class, 'course_id', 'id');
    }

    public function getCurriculum()
    {
        return $this->hasMany(CourseCurriculumItems::class, 'course_id', 'id');
    }

    public function getDuration()
    {
        //lay so gio hoc
        $courseId = $this->id;
        $duration = DB::table('media')->whereIn('curriculum_item', function ($query) use ($courseId) {
            $query->select('id')->from('course_curriculum_items')->where('course_id', $courseId);
        })->sum('duration');
        return $duration;
    }

    public function getRating()
    {
        return $this->hasMany(Rating::class, 'course', 'id');
    }

    public function getClassLevel()
    {
        return $this->belongsToMany(ClassLevel::class, (new CourseLdp())->getTable(), 'course_id', 'classlevel');
    }

    public function getAdvertise()
    {
        return $this->hasMany(Advertise::class, 'course_id');
    }

    function getOrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'course_id');
    }

    function getLastCurriculum()
    {
        $last = $this->getCurriculum->where('type', '!=', 'section')->sortBy('course_id')->sortBy('index')->first();
        $detail = $this->getOrderDetail->where('customer', \Auth::id())->first();
        if ($detail && $detail->getCurriculumItems) {
            $last = $detail->getCurriculumItems;
        }
        return $last;
    }

    function getThumbnail()
    {
        return isset($this->getLdp->thumbnail) ? $this->getLdp->thumbnail : 'adminux/img/course-df-thumbnail.jpg';
    }

    function getAverageRating()
    {
        return $this->getRating->avg('rating_number') ? floor($this->getRating->avg('rating_number') * 2) / 2 : 0;
    }

    function getYourRating()
    {
        return isset($this->getRating->where('author', \Auth::id())->first()->rating_number) ? $this->getRating->where('author', \Auth::id())->first()->rating_number : 0;
    }

    function getTotalStudent()
    {
        return $this->getOrderDetail->where('status', 'done')->groupBy('customer')->count();
    }

    function getStudents()
    {
        return $this->getOrderDetail->where('status', 'done')->groupBy('customer');
    }

    function getVideoPromo()
    {
        return isset($this->getLdp->video_promo) ? $this->getLdp->video_promo : '';
    }

    function getRelateCourseByTeacher()
    {
        return $this->owner->course->where('status', 'active')->where('id', '!=', $this->id)->take(3);
    }

    function checkBought()
    {
        $return = false;
        if (\Auth::check()) {
            $count = OrderDetail::where('course_id', $this->id)
                ->where('customer', \Auth::id())
                ->where('status', 'done')
                ->count();
            if ($count > 0 || \Auth::id() == $this->author) {
                $return = true;
            }
        }
        return $return;
    }

    function checkBoughtWithId($id)
    {
        $return = false;
        $count = OrderDetail::where('course_id', $this->id)
            ->where('customer', $id)
            ->where('status', 'done')
            ->count();
        if ($count > 0 || $id == $this->author) {
            $return = true;
        }
        return $return;
    }

    public function getCountFinishItem()
    {
        $return = 0;
        if (\Auth::check()) {
            $return = CurriculumProgress::where('course_id', $this->id)
                ->where('student', \Auth::id())
                ->where('status', 3)
                ->count();
        }
        return $return;
    }

    function getProcess()
    {
        $return = 0;
        if (\Auth::check()) {
            $finish = $this->getCountFinishItem();
            $total_curriculum = $this->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->count();
            $return = $total_curriculum > 0 ? $finish / $total_curriculum * 100 : 0;
        }
        return $return;
    }

    public function getCountFinishItemStudent($studentId)
    {
        $return = CurriculumProgress::where('course_id', $this->id)
            ->where('student', $studentId)
            ->where('status', 3)
            ->count();
        return $return;
    }

    function getProcessStudent($studentId)
    {
        $finish = $this->getCountFinishItem($studentId);
        $total_curriculum = $this->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->count();
        $return = $total_curriculum > 0 ? $finish / $total_curriculum * 100 : 0;
        return $return;
    }

    static function getFilter($type, $request)
    {
        $courses = Course::where('status', 'active');
        switch ($type) {
            case 'search':
                $courses = $courses->where('slug', 'LIKE', '%' . stripUnicode($request->q) . '%');
                $courses = $courses->whereHas('getLdp', function ($query) use ($request) {
                    if (!empty($request->subject)) {
                        $query->whereIn('subject', $request->subject);
                    }
                    if (!empty($request->classlevel)) {
                        $query->whereIn('classlevel', $request->classlevel);
                    }
                    if (!empty($request->level)) {
                        $query->whereIn('level', $request->level);
                    }
                });
                if (!empty($request->rating)) {
                    $courses = $courses->whereHas('getRating', function ($query) use ($request) {
                        $query->groupBy('rating.course');
                        foreach ($request->rating as $rating) {
                            $query->orHavingRaw('FLOOR (AVG(rating_number) * 2) / 2 >= ? AND FLOOR (AVG(rating_number) * 2) / 2 <= ?', [$rating - 1, $rating]);
                        }
                    });
                }
                if (!empty($request->type)) {
                    $courses = $courses->where('type', $request->type);
                }
                if (!empty($request->video)) {
                    $courses = $courses->whereHas('getCurriculum', function ($query) {
                        $query->where('type', '!=', 'section')->where('status', 'active')->whereHas('getMedia');
                    });
                }
                if (!empty($request->price)) {
                    if (count($request->price) == 1) {
                        $compare = in_array('free', $request->price) ? '=' : '>';
                        if (empty(app('sale_system'))) {
                            $courses = $courses->where('price', $compare, 0);
                        } else {
                            $courses = $courses->where(function ($query) use ($compare) {
                                $query->where(function ($query) use ($compare) {
                                    $query->where('approve_sale_system', 'disable');
                                    $query->where('price', $compare, 0);
                                })->orWhere(function ($query) use ($compare) {
                                    $sale = app('sale_system')->where('price', $compare, 0)->first();
                                    $query->where('approve_sale_system', 'active');
                                    $query->where('price', '>=', $sale->min_price)->where('price', '<=', $sale->max_price);
                                });
                            });
                        }
                    }
                }
                break;
            case 'list':
                $cl = ClassLevel::select(['id', 'name'])->where('slug', $request->class)->get()->first();
                $sb = Subject::select(['id', 'name', 'seo_title', 'seo_description', 'seo_keywords'])->where('slug', $request->subject)->get()->first();
                $clId = $cl->id;
                $sbId = $sb->id;
                $courses = $courses->whereHas('getLdp', function ($query) use ($clId, $sbId) {
                    $query->where('classlevel', $clId)->where('subject', $sbId);
                });
                if (!empty($request->rating)) {
                    $courses = $courses->whereHas('getRating', function ($query) use ($request) {
                        $query->groupBy('rating.course');
                        foreach ($request->rating as $rating) {
                            $query->orHavingRaw('FLOOR (AVG(rating_number) * 2) / 2 >= ? AND FLOOR (AVG(rating_number) * 2) / 2 <= ?', [$rating - 1, $rating]);
                        }
                    });
                }
                if (!empty($request->type)) {
                    $courses = $courses->where('type', $request->type);
                }
                if (!empty($request->type)) {
                    $courses = $courses->where('type', $request->type);
                }
                if (!empty($request->video)) {
                    $courses = $courses->whereHas('getCurriculum', function ($query) {
                        $query->where('type', '!=', 'section')->where('status', 'active')->whereHas('getMedia');
                    });
                }
                if (!empty($request->price)) {
                    if (count($request->price) == 1) {
                        $compare = in_array('free', $request->price) ? '=' : '>';
                        if (empty(app('sale_system'))) {
                            $courses = $courses->where('price', $compare, 0);
                        } else {
                            $courses = $courses->where(function ($query) use ($compare) {
                                $query->where(function ($query) use ($compare) {
                                    $query->where('approve_sale_system', 'disable');
                                    $query->where('price', $compare, 0);
                                })->orWhere(function ($query) use ($compare) {
                                    $sale = app('sale_system')->where('price', $compare, 0)->first();
                                    $query->where('approve_sale_system', 'active');
                                    $query->where('price', '>=', $sale->min_price)->where('price', '<=', $sale->max_price);
                                });
                            });
                        }
                    }
                }
                break;
            case 'bought':
                $user = \Auth::user();
                $courses = $courses->whereHas('getOrderDetail', function ($query) use ($user) {
                    $query->where('customer', $user->id)
                        ->where('status', 'done');
                });
                break;
            default:
                break;
        }
        if ($request->key == 'process') {

        } else {
            if ($request->key && $request->order) {
                $courses = $courses->orderBy($request->key, $request->order);
            }
        }
        $courses = $courses->paginate(21);
        return $courses;
    }

    public function getCurriculumVideo()
    {
        $count = 0;
        foreach ($this->getCurriculum->where('type', '!=', 'section')->where('status', 'active')->load('getMedia') as $item) {
            if ($item->checkVideoCount() > 0)
                $count++;
        }
        return $count;
    }

    public function countCurriculumSection()
    {
        $count = $this->getCurriculum->where('type', '!=', 'test')->where('status', 'active')->count();
        return $count;
    }

    public function countCurriculumTest()
    {
        $count = $this->getCurriculum->where('type', 'test')->where('status', 'active')->count();
        return $count;
    }

    public function getUserDoExam()
    {
        return $this->belongsToMany(Users::class, 'exam_user', 'exam_id', 'user_id');
    }

    public function getCompany()
    {
        return $this->hasOne(ClassLevel::class, 'id', 'classlevel');
    }
}