<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            


            ['class_id'=>'1', 'name' => 'AFSINDA S.I.', 'gender' => 'F', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'1', 'name' => 'ANDREW P.L.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'2', 'name' => 'AFAREL N.F.N.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'2', 'name' => 'ARLITA S.L.', 'gender' => 'F', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'3', 'name' => 'AFAF A.A.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'3', 'name' => 'ANISA K.', 'gender' => 'F', 'level' => 'X', 'major' => 'Teknik Komputer dan Jaringan'],
            
            ['class_id'=>'7', 'name' => 'ADITYA P.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'7', 'name' => 'CHRISTENSEN E.S.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'8', 'name' => 'ACHMAD W.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'8', 'name' => 'DWI S.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'9', 'name' => 'ADITYA J.O.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'9', 'name' => 'ERIL E.', 'gender' => 'M', 'level' => 'X', 'major' => 'Teknik Kendaraan Ringan'],
            
            ['class_id'=>'17', 'name' => 'ADINDA B.A.', 'gender' => 'F', 'level' => 'X', 'major' => 'Akuntansi'],
            ['class_id'=>'17', 'name' => 'AHMAD N.H.', 'gender' => 'M', 'level' => 'X', 'major' => 'Akuntansi'],
            ['class_id'=>'17', 'name' => 'BILQIS A.S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Akuntansi'],
            ['class_id'=>'17', 'name' => 'CANCERREFY H.J.S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Akuntansi'],
            ['class_id'=>'17', 'name' => 'DWI M.W.', 'gender' => 'F', 'level' => 'X', 'major' => 'Akuntansi'],
            ['class_id'=>'17', 'name' => 'ISYE S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Akuntansi'],
            
            ['class_id'=>'13', 'name' => 'ANISA S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'13', 'name' => 'BUNGA N.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'13', 'name' => 'DANIELLA Z.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'13', 'name' => 'FIRDA M.S.FIRDA M.S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'13', 'name' => 'HANI N.S.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'13', 'name' => 'ILENNIA P.', 'gender' => 'F', 'level' => 'X', 'major' => 'Administrasi Perkantoran'],
            
            ['class_id'=>'4', 'name' => 'AHMAD R.A.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'4', 'name' => 'BERLIAN P.L.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'5', 'name' => 'DAMAR A.P.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'5', 'name' => 'ADAM Z.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'6', 'name' => 'BINTANG A.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            ['class_id'=>'6', 'name' => 'DARIS Y.M.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Komputer dan Jaringan'],
            
            ['class_id'=>'10', 'name' => 'ABDUH S.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'10', 'name' => 'CRISTIAN L.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'11', 'name' => 'ABDUL R.A.G.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'11', 'name' => 'BAGUS A.P.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'12', 'name' => 'ADIB S.R.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            ['class_id'=>'12', 'name' => 'DIKRI A.M.', 'gender' => 'M', 'level' => 'XI', 'major' => 'Teknik Kendaraan Ringan'],
            
            ['class_id'=>'19', 'name' => 'AIRIN S.L.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            ['class_id'=>'19', 'name' => 'DINDA Q.S.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            ['class_id'=>'19', 'name' => 'FARISYA I.S.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            ['class_id'=>'19', 'name' => 'GINA R.A.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            ['class_id'=>'19', 'name' => 'HANIFATU K.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            ['class_id'=>'19', 'name' => 'NICKEN A.M.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Akuntansi'],
            
            ['class_id'=>'15', 'name' => 'ALISA N.I.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'15', 'name' => 'CYNTIA D.P.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'15', 'name' => 'DEWITA A.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'16', 'name' => 'ADELIA A.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'16', 'name' => 'BILQIS H.S.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
            ['class_id'=>'16', 'name' => 'DELLA A.R.', 'gender' => 'F', 'level' => 'XI', 'major' => 'Administrasi Perkantoran'],
        ];

        foreach ($data as $item) {
            Student::create([ 
                'class_id' => $item['class_id'],
                'name' => $item['name'],
                'gender' => $item['gender'],
                'major' => $item['major'],
            ]);
        }
    }
}
