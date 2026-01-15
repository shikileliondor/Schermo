<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $studentId = DB::table('students')->insertGetId([
            'first_name' => 'Amina',
            'last_name' => 'Diallo',
            'birth_date' => '2012-05-12',
            'email' => 'amina@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subjectId = DB::table('subjects')->insertGetId([
            'name' => 'Mathématiques',
            'code' => 'MATH-101',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('payments')->insert([
            'student_id' => $studentId,
            'amount' => 120.00,
            'method' => 'cash',
            'paid_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('timetables')->insert([
            'subject_id' => $subjectId,
            'day_of_week' => 'lundi',
            'starts_at' => '08:00:00',
            'ends_at' => '10:00:00',
            'room' => 'Salle A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
