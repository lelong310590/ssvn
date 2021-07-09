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
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Users\Models\Users;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $check = Users::where('phone', $row['phone']);
            if ($check == null) {
                Users::create([
                    'phone' => $row['phone'],
                    'password' => $row['password'],
                    'first_name' => $row['first_name'],
                    'sex' => $row['sex'],
                    'email' => $row['email'],
                    'classlevel' => $row['classlevel']
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}