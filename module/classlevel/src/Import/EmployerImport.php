<?php
/**
 * EmployerImport.php
 * Created by: trainheartnet
 * Created at: 11/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace ClassLevel\Import;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Users\Models\Users;

class EmployerImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public $classLevel = null;

    public function __construct($classLevel)
    {
        $this->classLevel = $classLevel;
    }

    public function collection(Collection $rows)
    {
        $password = config('base.default_password');
        DB::beginTransaction();
        try {
            foreach ($rows as $row)
            {
                $value = array_values($row->toArray());
                $check = Users::where('citizen_identification', $value[1])->get();
                $sex = 'male';
                switch ($value[4]) {
                    case 'Nam':
                        $sex = 'male';
                        break;
                    case 'Nữ':
                        $sex = 'female';
                        break;
                    case 'Khác':
                        $sex = 'other';
                        break;
                    default:
                        $sex = 'other';
                }
                if ($check->count() == 0) {
                    DB::table('users')->insert([
                        'citizen_identification' => $value[1],
                        'phone' => $value[2],
                        'password' => bcrypt($password),
                        'first_name' => $value[3],
                        'sex' => $sex,
                        'dob' => Carbon::parse($value[5]),
                        'email' => $value[6],
                        'classlevel' => $this->classLevel,
                        'hard_role' => 1,
                        'status' => 'active'
                    ]);
                }
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Có lỗi xảy ra khi import dữ liệu, vui lòng kiểm tra file nguồn');
            // something went wrong
        }
    }

    public function headingRow(): int
    {
        return 4;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}