<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['course_id', 'file_name', 'file_path', 'created_at'];
    protected $useTimestamps = false;

    /**
     * Insert a new material record
     * @param array $data
     * @return int|bool Insert ID or false
     */
    public function insertMaterial($data)
    {
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     * @param int $course_id
     * @return array
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get material by ID with course info
     * @param int $material_id
     * @return array|null
     */
    public function getMaterialWithCourse($material_id)
    {
        return $this->select('materials.*, courses.course_name, courses.course_code')
                    ->join('courses', 'courses.id = materials.course_id')
                    ->where('materials.id', $material_id)
                    ->first();
    }

    /**
     * Delete material by ID
     * @param int $material_id
     * @return bool
     */
    public function deleteMaterial($material_id)
    {
        return $this->delete($material_id);
    }
}
