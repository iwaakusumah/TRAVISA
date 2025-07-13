<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            ['class_id' => 1, 'name' => 'Lamsarina, S.Th.', 'email' => 'lamsarina@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 2, 'name' => 'Ahmad Nursyam, S.Pd.', 'email' => 'syam@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 3, 'name' => 'Mesa Irdianto, S.T.', 'email' => 'mesa@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 4, 'name' => 'Agus Darsono, S.T.', 'email' => 'agus@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 5, 'name' => 'Lulyk Susanahaji, S.Pd.', 'email' => 'lulyk@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 7, 'name' => 'Ema Susilawati, S.Pd.', 'email' => 'ema@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 8, 'name' => 'Dede Nurrahmayanti, S.E.', 'email' => 'dede@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 9, 'name' => 'Nunuk Ade Y, S.Pd.', 'email' => 'ade@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 10, 'name' => 'Husni Mubarok, S.T.', 'email' => 'husni@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 11, 'name' => 'Farid Alal Muslimin, S.Pdi.', 'email' => 'farid@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 12, 'name' => 'Firdaus, S.T.', 'email' => 'firdaus@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 13, 'name' => 'Siti Subarti, S.Ag.', 'email' => 'siti@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 15, 'name' => 'Wiwik Meidiyati, S.Pd.', 'email' => 'wiwik@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 16, 'name' => 'Sri Andini, S.Pd.', 'email' => 'sri@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 17, 'name' => 'Ria Erpina, S.E.', 'email' => 'ria@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => 19, 'name' => 'Ir. Betri Yenita.', 'email' => 'betri@example.com', 'password' => Hash::make('password'), 'role' => 'homeroom_teacher'],
            ['class_id' => null, 'name' => 'Sabaruddin Sinulingga, S.M., M.M.', 'email' => 'sabaruddin@example.com', 'password' => Hash::make('password'), 'role' => 'headmaster'],
            ['class_id' => null, 'name' => 'Tata Usaha', 'email' => 'tu@example.com', 'password' => Hash::make('password'), 'role' => 'administration'],
            ['class_id' => null, 'name' => 'Wakil Kesiswaan', 'email' => 'wakasis@example.com', 'password' => Hash::make('password'), 'role' => 'staff_student'],
        ];

        foreach ($data as $item) {
            User::create([
                'class_id' => $item['class_id'],
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
                'role' => $item['role'],
            ]);
        }
    }
}