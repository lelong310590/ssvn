<?php
/**
 * ExportLocal.php
 * Created by: trainheartnet
 * Created at: 16/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Export;

use Base\Repositories\DistrictsRepository;
use Base\Repositories\ProvincesRepository;
use Base\Repositories\WardsRepository;
use ClassLevel\Models\ClassLevel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Subject\Repositories\SubjectRepository;
use Users\Models\Users;

class ExportLocal implements FromView, WithStyles, WithColumnFormatting
{
    public $company;

    public $manager;

    public $province;
    public $district;
    public $ward;

    public function __construct($company, $manager = false, $province = false, $district = false, $ward = false)
    {
        $this->company = $company;
        $this->manager = $manager;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
    }

    public function view(): View
    {
        $course = DB::table('course')
            ->where('status', '=', 'active')
            ->take(7)
            ->get();

        if ($this->province != false) {
            $companies = $this->getCompany($this->province, $this->district, $this->ward);
            $province = app(ProvincesRepository::class)->find($this->province);
            $district = false;
            $ward = false;

            $registerdSubject = app(SubjectRepository::class)->all();

            if ($this->district != false) {
                $district = app(DistrictsRepository::class)->find($this->district);
            }
            if ($this->ward != false) {
                $ward = app(WardsRepository::class)->find($this->ward);
            }

            $statByArea = $this->getStatsByArea($this->province, $this->district);

            return view('nqadmin-users::frontend.export.global', compact(
                'companies',
                'course',
                'district',
                'ward',
                'province',
                'registerdSubject',
                'statByArea'
            ));

        } else {
            $company = $this->company;

            $query = Users::where('classlevel', $company->id)
                ->where('hard_role', 1)
                ->with('getCertificate');

            if ($this->manager != false) {
                $query->where('manager', $this->manager);
            }

            $employers = $query->get();

            $registerdSubject = $company->subject()->get();

            return view('nqadmin-users::frontend.export.local', compact(
                'company',
                'course',
                'employers',
                'registerdSubject'
            ));
        }

    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return \bool[][][]
     */
    public function styles(Worksheet $sheet)
    {

    }

    public function getStatsByArea($province, $district)
    {
        if ($district == null) {
            return app(DistrictsRepository::class)
                ->withCount('getCompany')
                ->with(['getEnjoynedCompany' => function($q) {
                    return $q->where('user_subject.type', 'enterprise')
                        ->selectRaw('vjc_user_subject.*, vjc_user_subject.subject,  COUNT(*) AS total_enjoyed_company');
                }])
                ->with(['getCompanyCertificate' => function($q) {
                    return $q->where('certificate.company_id', '!=', null)
                        ->where('type', 'enterprise')
                        ->selectRaw('vjc_certificate.district, vjc_certificate.subject_id,  COUNT(*) AS total_completed_company')
                        ->groupBy('certificate.subject_id');
                }])
                ->with(['getEnjoynedEmployerInCompany' => function($q) {
                    return $q->where('user_subject.type', 'personal')
                        ->selectRaw('vjc_user_subject.*, vjc_user_subject.subject,  COUNT(*) AS total_enjoyed_employer');
                }])
                ->with(['getCertificate' => function($q) {
                    return $q->where('certificate.company_id', '!=', null)
                        ->where('type', 'personal')
                        ->selectRaw('vjc_certificate.district, vjc_certificate.subject_id,  COUNT(*) AS total_completed_employer')
                        ->groupBy('certificate.subject_id');
                }])
                ->where('province_id', $province)
                ->get();
        } else {
            return app(WardsRepository::class)
                ->withCount('getCompany')
                ->with(['getEnjoynedCompany' => function($q) {
                    return $q->where('user_subject.type', 'enterprise')
                        ->selectRaw('vjc_user_subject.*, vjc_user_subject.subject,  COUNT(*) AS total_enjoyed_company');
                }])
                ->with(['getCompanyCertificate' => function($q) {
                    return $q->where('certificate.company_id', '!=', null)
                        ->where('type', 'enterprise')
                        ->selectRaw('vjc_certificate.district, vjc_certificate.subject_id,  COUNT(*) AS total_completed_company')
                        ->groupBy('certificate.subject_id');
                }])
                ->with(['getEnjoynedEmployerInCompany' => function($q) {
                    return $q->where('user_subject.type', 'personal')
                        ->selectRaw('vjc_user_subject.*, vjc_user_subject.subject,  COUNT(*) AS total_enjoyed_employer');
                }])
                ->with(['getCertificate' => function($q) {
                    return $q->where('certificate.company_id', '!=', null)
                        ->where('type', 'personal')
                        ->selectRaw('vjc_certificate.district, vjc_certificate.subject_id,  COUNT(*) AS total_completed_employer')
                        ->groupBy('certificate.subject_id');
                }])
                ->where('district_id', $district)
                ->get();
        }
    }

    /**
     * @param $province
     * @param $district
     * @param $ward
     * @return mixed
     */
    public function getCompany($province, $district, $ward)
    {
        $companyModel = ClassLevel::withCount(['getUsers']);
        if ($province != null) {
            if ($district != null) {
                if ($ward != null) {
                    $companyModel = ClassLevel::withCount(['getUsers'])
                        ->where('province', $province)
                        ->where('district', $district)
                        ->where('ward', $ward);
                } else {
                    $companyModel = ClassLevel::withCount(['getUsers'])
                        ->where('province', $province)
                        ->where('district', $district);
                }
            } else {
                $companyModel = ClassLevel::withCount(['getUsers'])
                    ->where('province', $province);
            }
        }

        $result = $companyModel
            ->with(['getEnjoynedEmployerInCompany' => function($q) {
                return $q->where('user_subject.type', 'personal')
                    ->selectRaw('vjc_user_subject.*, vjc_user_subject.subject,  COUNT(*) AS total_enjoyed_employer');
            }])
            ->with(['getCertificate' => function($q) {
                return $q->where('certificate.company_id', '!=', null)
                    ->where('type', 'personal')
                    ->selectRaw('vjc_certificate.*, vjc_certificate.subject_id,  COUNT(*) AS total_completed_employer')
                    ->groupBy('certificate.subject_id');
            }])
            ->get();

        return $result;
    }
}