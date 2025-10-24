<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_code' => 'ITE311',
                'course_name' => 'Web Systems and Technologies',
                'description' => 'Introduction to web development, covering HTML, CSS, JavaScript, PHP, and database integration.',
                'units' => 3,
                'created_at' => Time::now(),
            ],
            [
                'course_code' => 'CS101',
                'course_name' => 'Introduction to Computer Science',
                'description' => 'Fundamental concepts of computer science including algorithms, data structures, and programming basics.',
                'units' => 3,
                'created_at' => Time::now(),
            ],
            [
                'course_code' => 'IT201',
                'course_name' => 'Database Management Systems',
                'description' => 'Study of database design, SQL, normalization, and database management principles.',
                'units' => 3,
                'created_at' => Time::now(),
            ],
            [
                'course_code' => 'IT301',
                'course_name' => 'Software Engineering',
                'description' => 'Software development methodologies, project management, testing, and quality assurance.',
                'units' => 3,
                'created_at' => Time::now(),
            ],
            [
                'course_code' => 'CS202',
                'course_name' => 'Data Structures and Algorithms',
                'description' => 'Advanced data structures, algorithm design, analysis, and optimization techniques.',
                'units' => 3,
                'created_at' => Time::now(),
            ],
        ];

        $this->db->table('courses')->insertBatch($data);
    }
}
