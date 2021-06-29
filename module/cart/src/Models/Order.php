<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:44 AM
 */

namespace Cart\Models;

use Course\Models\CurriculumProgress;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['customer', 'total_price', 'payment_method ', 'status', 'token'];

    /**
     * Relation 1 - n with Detail
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function getCustomer()
    {
        return $this->belongsTo(Users::class, 'customer');
    }

    public function getOrderCode()
    {
        return 'VJ-' . $this->id . '-' . $this->customer . '-' . date('Ymd', strtotime($this->created_at));
    }

    public function getTextStatusAttribute()
    {
        switch ($this->status) {
            case 'create':
                $class = 'warning';
                $text = 'Chưa thanh toán';
                break;
            case 'done':
                $class = 'success';
                $text = 'Đã thanh toán';
                break;
            case 'cancel':
                $class = 'success';
                $text = 'Đã thanh toán';
                break;
            default:
                $class = 'warning';
                $text = 'Chưa thanh toán';
                break;
        }

        return ['class' => $class, 'text' => $text];
    }

    public function getTextPaymentMethodAttribute()
    {
        //'transfer','atm','direct','phone'
        switch ($this->payment_method) {
            case 'transfer':
                $text = 'Chuyển khoản ngân hàng';
                break;
            case 'atm':
                $text = 'Thẻ ATM có Internet Baking';
                break;
            case 'direct':
                $text = 'Thanh toán trực tiếp';
                break;
            case 'phone':
                $text = 'Thanh toán qua điện thoại';
                break;
        }
        return $text;
    }

    public function done()
    {
        foreach ($this->detail as $item) {
            foreach ($item->course->getCurriculum as $curriculum) {
                CurriculumProgress::create([
                    'course_id' => $curriculum->course_id,
                    'curriculum_id' => $curriculum->id,
                    'student' => $item->customer,
                    'progress' => 0,
                    'status' => 1,
                ]);
            }
            $item->course->bought = $item->course->bought + 1;
            $item->course->bought1 = $item->course->bought1 + 1;
            $item->course->bought2 = $item->course->bought2 + 1;
            $item->course->bought3 = $item->course->bought3 + 1;
            $item->course->save();

            $item->course->owner->sold_course = $item->course->owner->sold_course + 1;
            $item->course->owner->save();

            $item->status = 'done';
            $item->save();
        }
        $this->update(['status' => 'done']);
    }
}