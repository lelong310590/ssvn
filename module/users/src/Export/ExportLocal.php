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
            $statByArea = $this->getStatsByArea($this->province, $this->district);

            if ($this->district != false) {
                $district = app(DistrictsRepository::class)->find($this->district);
            }
            if ($this->ward != false) {
                $ward = app(WardsRepository::class)->find($this->ward);
            }

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
        return [
            // Style the first row as bold text.
            3    => ['font' => ['bold' => true]],
            4    => ['font' => ['bold' => true]],
            5    => ['font' => ['bold' => true]],
        ];
    }

    public function getCompany($province, $district, $ward)
    {
        $companyModel = ClassLevel::withCount(['getUsers', 'getCertificate']);
        if ($province != null) {
            if ($district != null) {
                if ($ward != null) {
                    $companyModel = ClassLevel::withCount(['getUsers', 'getCertificate'])
                        ->where('province', $province)
                        ->where('district', $district)
                        ->where('ward', $ward);
                } else {
                    $companyModel = ClassLevel::withCount(['getUsers', 'getCertificate'])
                        ->where('province', $province)
                        ->where('district', $district);
                }
            } else {
                $companyModel = ClassLevel::withCount(['getUsers', 'getCertificate'])
                    ->where('province', $province);
            }
        }

        $result = $companyModel
            ->with(['getLearnedUser' => function($q) {
                $q->selectRaw('vjc_order_details.customer, vjc_order_details.course_id,  COUNT(*) AS total_learned_employer')
                    ->groupBy('order_details.course_id');
            }])
            ->with(['getCertificate' => function($q) {
                $q->selectRaw('vjc_certificate.user_id, vjc_certificate.course_id,  COUNT(*) AS total_completed_employer')
                    ->groupBy('certificate.course_id');
            }])
            ->get();

        return $result;
    }

    /**
     * @param $province
     * @param $district
     * @return mixed
     */
    public function getStatsByArea($province, $district)
    {
        if ($district == null) {
            return app(DistrictsRepository::class)
                ->withCount('getCompany')
                ->with(['getCertificate' => function($q) {
                    return $q->selectRaw('vjc_certificate.user_id, vjc_certificate.subject_id,  COUNT(*) AS total_completed_employer')
                        ->groupBy('certificate.subject_id');
                }])
                ->where('province_id', $province)
                ->get();
        } else {
            return app(WardsRepository::class)
                ->withCount('getCompany')
                ->with(['getCertificate' => function($q) {
                    return $q->selectRaw('vjc_certificate.user_id, vjc_certificate.subject_id,  COUNT(*) AS total_completed_employer')
                        ->groupBy('certificate.subject_id');
                }])
                ->where('district_id', $district)
                ->get();
        }
    }
}