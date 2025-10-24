<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Materials extends BaseController
{
    /**
     * Display file upload form and handle file upload
     * @param int $course_id
     * @return mixed
     */
    public function upload($course_id)
    {
        // Check if user is logged in and is admin or teacher
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'teacher') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin or Teacher only.');
        }

        $courseModel = new CourseModel();
        $course = $courseModel->find($course_id);

        if (!$course) {
            return redirect()->to('/dashboard')->with('error', 'Course not found.');
        }

        // Handle POST request (file upload)
        if ($this->request->getMethod() === 'POST') {
            $validationRule = [
                'material_file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[material_file]'
                        . '|max_size[material_file,10240]'
                        . '|ext_in[material_file,pdf,doc,docx,ppt,pptx,xlsx,xls,txt,zip,rar]',
                ],
            ];

            if (!$this->validate($validationRule)) {
                return redirect()->back()->with('error', 'File validation failed: ' . implode(', ', $this->validator->getErrors()));
            }

            $file = $this->request->getFile('material_file');

            if ($file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = WRITEPATH . 'uploads/materials';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate unique filename
                $newName = $file->getRandomName();
                
                // Move file to upload directory
                $file->move($uploadPath, $newName);

                // Save to database
                $materialModel = new MaterialModel();
                $data = [
                    'course_id'  => $course_id,
                    'file_name'  => $file->getClientName(),
                    'file_path'  => 'uploads/materials/' . $newName,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                if ($materialModel->insertMaterial($data)) {
                    return redirect()->to('/dashboard')->with('success', 'Material uploaded successfully!');
                } else {
                    // Delete uploaded file if database insert fails
                    unlink($uploadPath . '/' . $newName);
                    return redirect()->back()->with('error', 'Failed to save material to database.');
                }
            } else {
                return redirect()->back()->with('error', 'File upload failed: ' . $file->getErrorString());
            }
        }

        // Show upload form (GET request)
        $data = [
            'course' => $course,
            'role'   => $role,
            'name'   => session()->get('username'),
        ];

        return view('materials/upload', $data);
    }

    /**
     * Delete a material
     * @param int $material_id
     * @return mixed
     */
    public function delete($material_id)
    {
        // Check if user is logged in and is admin or teacher
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'teacher') {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin or Teacher only.');
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->find($material_id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Delete file from server
        $filePath = WRITEPATH . $material['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($materialModel->deleteMaterial($material_id)) {
            return redirect()->back()->with('success', 'Material deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete material from database.');
        }
    }

    /**
     * Download a material (for enrolled students only)
     * @param int $material_id
     * @return mixed
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $materialModel = new MaterialModel();
        $material = $materialModel->getMaterialWithCourse($material_id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        $user_id = session()->get('user_id');
        $role = session()->get('role');

        // Admin and teacher can download any material
        if ($role === 'admin' || $role === 'teacher') {
            return $this->forceDownload($material);
        }

        // Students must be enrolled in the course
        if ($role === 'student') {
            $enrollmentModel = new EnrollmentModel();
            $isEnrolled = $enrollmentModel->isAlreadyEnrolled($user_id, $material['course_id']);

            if (!$isEnrolled) {
                return redirect()->back()->with('error', 'Access denied. You must be enrolled in this course to download materials.');
            }

            return $this->forceDownload($material);
        }

        return redirect()->back()->with('error', 'Access denied.');
    }

    /**
     * Force file download
     * @param array $material
     * @return mixed
     */
    private function forceDownload($material)
    {
        $filePath = WRITEPATH . $material['file_path'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        helper('download');
        return $this->response->download($filePath, null)->setFileName($material['file_name']);
    }
}
