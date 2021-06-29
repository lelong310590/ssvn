<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:44 PM
 */

namespace Coupon\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Coupon\Http\Requests\CreateCouponRequest;
use Base\Supports\FlashMessage;
use Coupon\Repositories\CouponRepository;
use Debugbar;
use Auth;
use Illuminate\Http\Request;

class CouponController extends BaseController
{
    protected $repository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->repository = $couponRepository;
    }

    public function getSetting()
    {
        return view('nqadmin-course::backend.setting');
    }

    public function getIndex()
    {
        $data = $this->repository
            ->with('getLdp')
            ->orderBy('created_at', 'desc')
            ->all();
        return view('nqadmin-course::backend.index', [
            'data' => $data
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        return view('nqadmin-course::backend.create');
    }

    /**
     * @param \Course\Http\Requests\CreateCourseRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(CreateCouponRequest $request)
    {
        try {
            $input = $request->except('_token');
            $time = explode(' ', $input['deadline']);
            $date = explode('/', $time[0]);
            $deadline = $date[2] . '-' . $date[1] . '-' . $date[0] . ' ' . $time[1] . ':59';

            $input['deadline'] = $deadline;
            $input['author'] = Auth::id();
            if (strtotime($deadline) > time()) {
                $input['status'] = 'active';
            } else {
                $input['status'] = 'disable';
            }
            $coupon = $this->repository->create($input);
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }

    public function changeStatus(Request $request)
    {
        $coupon = $this->repository->find($request->id);
        if (strtotime($coupon->deadline) > time()) {
            $status = $coupon->status == 'active' ? 'disable' : 'active';
        } else {
            $status = 'disable';
        }

        try {
            $this->repository->update(['status' => $status], $request->id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}