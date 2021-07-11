<?php
/**
 * UsersImport.php
 * Created by: trainheartnet
 * Created at: 09/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Import;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Users\Models\Users;
use DB;

class UsersImport implements ToCollection, WithHeadingRow, WithChunkReading
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
                $check = Users::where('phone', $value[1])->get();
                if ($check->count() == 0) {
                    DB::table('users')->insert([
                        'phone' => $value[1],
                        'password' => bcrypt($password),
                        'first_name' => $value[2],
                        'sex' => $value[3],
                        'email' => $value[4],
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