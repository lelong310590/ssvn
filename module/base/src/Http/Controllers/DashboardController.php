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
use Base\Models\Districts;
use Base\Models\Provinces;
use Base\Models\Wards;
use Base\Repositories\DistrictsRepository;
use Base\Repositories\WardsRepository;
use Cart\Repositories\OrdersRepository;
use ClassLevel\Repositories\ClassLevelRepository;
use Course\Repositories\CourseRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Users\Models\Users;
use Users\Repositories\UsersRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http;

class DashboardController extends BaseController
{
    public function getIndex(
        UsersRepository $usersRepository,
        OrdersRepository $ordersRepository,
        CourseRepository $courseRepository,
        ClassLevelRepository $classLevelRepository,
        Request $request
    )
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

        $user = auth('nqadmin')->user();
//        $roles = $user->load('roles.perms');
//        $currentRole = $roles->roles->first()->name;
//        if ($currentRole == 'administrator') {
//            $classLevel = $classLevelRepository->findWhere([
//                'status' => 'active'
//            ]);
//        } else {
//            $classLevel = $classLevelRepository->findWhere([
//                'status' => 'active',
//                'id' => $user->classlevel
//            ]);
//        }

        $classLevel = $classLevelRepository->findWhere([
            'status' => 'active'
        ]);

        $detail = [];
        $companyId = $request->get('company_id');
        $courseId = $request->get('course_id');

        if ($companyId != null) {
            $currentCompany = $classLevelRepository->find($companyId);
            $employers = $usersRepository->with('course')->findWhere([
                'classlevel' => $currentCompany->id
            ]);

            $courseInCompany = $courseRepository->with('getLdp')
            ->whereHas('getLdp', function ($r) use ($currentCompany) {
                $r->where('course_ldp.classlevel', $currentCompany->id);
            })->scopeQuery(function ($q) use ($currentCompany) {
                return $q->where('status', 'active');
            });

            $detail['employers'] = $employers;
            $detail['courseInCompany'] = $courseInCompany;
            $detail['currentCompany'] = $currentCompany;
        }

        if ($courseId != null) {
            $selectedCourse = $courseRepository
                ->with('getLdp')
                ->find($courseId);

            $registerdUser = DB::table('order_details')->where('course_id', $selectedCourse->id)->distinct('customer')->count();
            $totalUserInCompany = $usersRepository->findWhere([
                'classlevel' => $companyId
            ])->count();

            $detail['selectedCourse'] = $selectedCourse;
            $detail['registerdUser'] = $registerdUser;
            $detail['totalUserInCompany'] = $totalUserInCompany;
        }

        return view('nqadmin-dashboard::backend.dashboard', [
            'activeUser' => $activeUser,
            'chartData' => $data,
            'currentMonthProfit' => $currentMonthProfit,
            'orderInMonth' => $orderInMonth,
            'courseInMonth' => $courseInMonth,
            'classLevel' => $classLevel,
            'detail' => $detail
        ]);
    }

    public function testMail($id)
    {
        return view('nqadmin-dashboard::mail.content.user.test');
        $user = Users::find($id);
        Mail::to($user)->send(new TestMail($user));
    }

    public function getCourseInCompany(
        Request $request,
        CourseRepository $courseRepository
    )
    {
        if (!$request->ajax()) {
            return false;
        }

        $companyId = $request->get('companyId');

        $courseInCompany = $courseRepository->with('getLdp')
            ->scopeQuery(function ($q) {
                return $q->where('status', 'active');
            })
            ->whereHas('getLdp', function ($r) use ($companyId) {
                $r->where('course_ldp.classlevel', $companyId);
            })
            ->orWhereHas('getLdp', function ($or) {
                $or->where('course_ldp.classlevel', null);
            })
            ->get();

        $html = '';

        foreach ($courseInCompany as $c) {
            $html .= '<option value="'.$c->id.'">'.$c->name.'</option>';
        }

        return response()->json($html);
    }


    public function getDistricts(
        Request $request,
        DistrictsRepository $districtsRepository
    )
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $html = '<option value="">-- Ch???n Qu???n / Huy???n --</option>';
        $provinceId = $request->get('provinceId');
        $districts = $districtsRepository->findWhere([
            'province_id' =>  $provinceId
        ]);

        foreach ($districts as $d) {
            $html .= '<option value="'.$d->id.'">'.$d->district_name.'</option>';
        }

        return response()->json(['html' => $html]);
    }

    /**
     * @param Request $request
     * @param WardsRepository $wardsRepository
     * @return Http\JsonResponse
     */
    public function getWards(
        Request $request,
        WardsRepository $wardsRepository
    )
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $html = '<option value="">-- Ch???n Ph?????ng / X?? --</option>';
        $districtId = $request->get('districtId');
        $wards = $wardsRepository->findWhere([
            'district_id' =>  $districtId
        ]);

        foreach ($wards as $w) {
            $html .= '<option value="'.$w->id.'">'.$w->ward_name.'</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function scriptGetCertificate(
        $id,
        ClassLevelRepository $classLevelRepository,
        UsersRepository $usersRepository
    )
    {
        $company = $classLevelRepository->find($id);
//        $employers =
    }
}