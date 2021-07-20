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
use Subject\Repositories\SubjectRepository;
use VerumConsilium\Browsershot\Facades\Screenshot;

class CertificateController extends BaseController
{
    public function createCertificate(
        Request $request,
        CertificateRepository $certificateRepository,
        CourseRepository $courseRepository,
        ClassLevelRepository $classLevelRepository,
        SubjectRepository $subjectRepository
    )
    {
        $subject_id = $request->get('subject_id');
        $type = $request->get('type');

        $user = auth('nqadmin')->user();

        $company = $classLevelRepository->find($user->classlevel);

        if ($type == 'personal') {
            $certificate = $certificateRepository->findWhere([
                'subject_id' => $subject_id,
                'user_id' => $user->id,
                'type' => $type
            ])->first();
        } else {
            $certificate = $certificateRepository->findWhere([
                'subject_id' => $subject_id,
                'company_id' => $company,
                'type' => $type
            ])->first();
        }


        if ($certificate == null) {
            $imageLink = '/upload/cert/'.time().base64_encode($user->first_name).'.png';

            $data = [
                'subject_id' => $subject_id,
                'user_id' => $user->id,
                'image' => $imageLink,
                'company_id' => $user->classlevel,
                'type' => $type
            ];

            if ($user->classlevel != null) {
                $companyInfo = $classLevelRepository->find($user->classlevel);
                $data['province'] = $companyInfo->province;
                $data['district'] = $companyInfo->district;
                $data['ward'] = $companyInfo->ward;
            }

            $certificate = $certificateRepository->create($data);

            $subject = $subjectRepository->find($subject_id);

            $browser = new Browsershot();

            $template = $subject != null ? $subject->template : 'nqadmin-course::frontend.certificate';

            $html = view($template, compact(
                'user', 'certificate', 'subject', 'company', 'type'
            ));

            $browser->html($html)
                ->ignoreHttpsErrors()
                ->noSandbox()
                ->windowSize(1122.52, 793.7)
                ->showBackground()
                ->save(public_path().$imageLink);

        }

        return redirect()->route('front.users.my-certificate.get');
    }
}