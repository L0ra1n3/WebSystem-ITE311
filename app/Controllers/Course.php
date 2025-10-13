<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Course extends BaseController
{
    public function enroll()
    {
        // ✅ Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized. Please login first.'
            ])->setStatusCode(401);
        }

        $user_id = session()->get('user_id');
        $course_id = $this->request->getPost('course_id');

        // ✅ Validate course_id
        if (!$course_id || !is_numeric($course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid course ID.'
            ])->setStatusCode(400);
        }

        $enrollModel = new EnrollmentModel();

        // ✅ Check if already enrolled
        if ($enrollModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        // ✅ Insert enrollment
        $enrollModel->enrollUser([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s')
        ]);

        // ✅ Return updated enrolled courses list
        $enrollments = $enrollModel->getUserEnrollments($user_id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Successfully enrolled!',
            'enrollments' => $enrollments
        ]);
    }
}
