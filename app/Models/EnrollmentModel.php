<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date'];

    public function enrollUser($data)
    {
        return $this->insert($data);
    }

 public function getUserEnrollments($user_id)
{
     return $this->select('enrollments.*, courses.id as course_id, courses.course_code, courses.course_name')
                ->join('courses', 'courses.id = enrollments.course_id')
                ->where('enrollments.user_id', $user_id)
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();
}



    public function isAlreadyEnrolled($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->first() !== null;
    }

    public function getAllEnrollmentsWithDetails()
    {
        return $this->select('enrollments.*, users.username, users.email, courses.course_code, courses.course_name, courses.units')
                    ->join('users', 'users.id = enrollments.user_id')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->where('users.role', 'student')
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }
}
