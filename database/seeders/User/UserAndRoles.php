<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAndRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // File 0
        $files0 = fopen(base_path('database/seeders/User/users.csv'), "r");
        $files1 = fopen(base_path('database/seeders/User/roles.csv'), "r");
        $files2 = fopen(base_path('database/seeders/User/permissions.csv'), "r");
        $files3 = fopen(base_path('database/seeders/User/role_user.csv'), "r");
        $files4 = fopen(base_path('database/seeders/User/permission_user.csv'), "r");
        $files5 = fopen(base_path('database/seeders/User/permission_role.csv'), "r");

        $firstLine0 = false;
        $firstLine1 = false;
        $firstLine2 = false;
        $firstLine3 = false;
        $firstLine4 = false;
        $firstLine5 = false;

        while (($data0 = fgetcsv($files0, 520, ",")) !== false) {
            if (!$firstLine0) {
                $cast = [
                    "name" => $data0['1'],
                    "email" => $data0['2'],
                    "password" => $data0['4'],
                    "instance_id" => (int)$data0['5'],
                ];
                User::create($cast);
            }
            $firstLine0 = false;
        }

        while (($data1 = fgetcsv($files1, 520, ",")) !== false) {
            if (!$firstLine1) {
                $cast = [
                    "name" => $data1['1'],
                    "display_name" => $data1['2']
                ];
                DB::table('roles')->insert($cast);
            }
            $firstLine1 = false;
        }

        while (($data2 = fgetcsv($files2, 520, ",")) !== false) {
            if (!$firstLine2) {
                $cast = [
                    "name" => $data2['1'],
                    "display_name" => $data2['2'],
                ];
                DB::table('permissions')->insert($cast);
            }
            $firstLine2 = false;
        }

        while (($data3 = fgetcsv($files3, 520, ",")) !== false) {
            if (!$firstLine3) {
                $cast = [
                    "role_id" => (int)$data3['0'],
                    "user_id" => (int)$data3['1'],
                    "user_type" => $data3['2'],
                ];
                DB::table('role_user')->insert($cast);
            }
            $firstLine3 = false;
        }

        while (($data4 = fgetcsv($files4, 520, ",")) !== false) {
            if (!$firstLine4) {
                $cast = [
                    "permission_id" => (int)$data4['0'],
                    "user_id" => (int)$data4['1'],
                    "user_type" => $data4['2']
                ];
                DB::table('permission_user')->insert($cast);
            }
            $firstLine4 = false;
        }

        while (($data5 = fgetcsv($files5, 520, ",")) !== false) {
            if (!$firstLine5) {
                $cast = [
                    "permission_id" => (int)$data5['0'],
                    "role_id" => (int)$data5['1'],
                ];
                DB::table('permission_role')->insert($cast);
            }
            $firstLine5 = false;
        }
    }
}
