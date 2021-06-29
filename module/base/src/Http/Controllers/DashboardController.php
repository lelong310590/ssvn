<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 11:56 PM
 */

namespace Base\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Mail\TestMail;
use Cart\Repositories\OrdersRepository;
use Course\Repositories\CourseRepository;
use Illuminate\Support\Facades\Mail;
use Users\Models\Users;
use Users\Repositories\UsersRepository;

class DashboardController extends BaseController
{
    public function getIndex(UsersRepository $usersRepository, OrdersRepository $ordersRepository, CourseRepository $courseRepository)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i ++) {
            $data[] = $ordersRepository->getProfitByMonth($i);
        }

        $activeUser = $usersRepository->getActiveUserInMonth();
        $currentMonth = (intval(date("m")));
        $currentMonthProfit = $ordersRepository->getProfitByMonth($currentMonth);
        $orderInMonth = $ordersRepository->getOrderInMonth();
        $courseInMonth = $courseRepository->getCourseInMonth();
        return view('nqadmin-dashboard::backend.dashboard', [
            'activeUser' => $activeUser,
            'chartData' => $data,
            'currentMonthProfit' => $currentMonthProfit,
            'orderInMonth' => $orderInMonth,
            'courseInMonth' => $courseInMonth
        ]);
    }

    public function testMail($id)
    {
        $user = Users::find($id);
        Mail::to($user)->send(new TestMail($user));
    }
}