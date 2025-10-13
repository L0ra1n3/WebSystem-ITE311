<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    
    // ✅ Allowed fields based on your table structure
    protected $allowedFields = [
        'course_code',   // e.g., "IT101"
        'course_name',   // e.g., "Introduction to IT"
        'description',   // course description
        'units',         // e.g., 3 or 4
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
