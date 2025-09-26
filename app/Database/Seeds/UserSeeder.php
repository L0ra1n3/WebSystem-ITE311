<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $passwordAdmin = password_hash('Admin123!', PASSWORD_DEFAULT);
        $passwordTeacher = password_hash('Teacher123!', PASSWORD_DEFAULT);
        $passwordStudent = password_hash('Student123!', PASSWORD_DEFAULT);

        $data = [
            [
                'email' => 'admin@example.com',
                'password' => $passwordAdmin,
                'role' => 'admin',
                'username' => 'Admin User',
                'created_at' => Time::now()
            ],
            [
                'email' => 'teacher@example.com',
                'password' => $passwordTeacher,
                'role' => 'teacher',
                'username' => 'Teacher User',
                'created_at' => Time::now()
            ],
            [
                'email' => 'student@example.com',
                'password' => $passwordStudent,
                'role' => 'student',
                'username' => 'Student User',
                'created_at' => Time::now()
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
