<?php
/**
 * CertificateController.php
 * Created by: trainheartnet
 * Created at: 08/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Course\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use ClassLevel\Repositories\ClassLevelRepository;
use Course\Repositories\CourseRepository;
use Course\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use VerumConsilium\Browsershot\Facades\Screenshot;

class CertificateController extends BaseController
{
    public function createCertificate(
        Request $request,
        CertificateRepository $certificateRepository,
        CourseRepository $courseRepository,
        ClassLevelRepository $classLevelRepository
    )
    {
        $course_id = $request->get('course_id');
        $user = auth('nqadmin')->user();

        $company = $classLevelRepository->find($user->classlevel);

        $certificate = $certificateRepository->findWhere([
            'course_id' => $course_id,
            'user_id' => $user->id
        ])->first();

        if ($certificate == null) {
            $imageLink = '/upload/cert/'.time().base64_encode($user->first_name).'.png';
            $certificate = $certificateRepository->create([
                'course_id' => $course_id,
                'user_id' => $user->id,
                'image' => $imageLink
            ]);

            $course = $courseRepository->scopeQuery(function ($query) {
                return $query->with('getLdp')->where('status', 'active');
            })->find($course_id);

            $borwser = new Browsershot();

            $html = view('nqadmin-course::frontend.certificate', compact(
                'user', 'certificate', 'course', 'company'
            ));

            $borwser->html($html)
                ->ignoreHttpsErrors()
                ->noSandbox()
                ->windowSize(1122.52, 793.7)
                ->showBackground()
                ->save(public_path().$imageLink);

        }

        return redirect()->route('front.users.certificate.get');
    }
}