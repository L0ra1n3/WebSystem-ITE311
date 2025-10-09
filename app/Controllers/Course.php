<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EnrollmentModel;

class Course extends Controller
{
    public function enroll()
    {
        // Load helpers
        helper(['form', 'url']);

        // Check if the user is logged in
        $session = session();
        $userId = $session->get('user_id'); // dapat may 'user_id' sa session mo

        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in.'
            ]);
        }

        // Get course_id from POST (AJAX)
        $courseId = $this->request->getPost('course_id');

        if (!$courseId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Missing course ID.'
            ]);
        }

        // Load Enrollment model
        $enrollModel = new \App\Models\EnrollmentModel();

        // Check if the user is already enrolled
        $existing = $enrollModel->where('user_id', $userId)
                                ->where('course_id', $courseId)
                                ->first();

        if ($existing) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        // Insert new enrollment record
        $data = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($enrollModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Enrollment successful!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to enroll. Please try again.'
            ]);
        }
    }
}
