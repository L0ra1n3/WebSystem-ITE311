<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email','password','role','name']; // adjust fields
    protected $returnType = 'array';
    protected $useTimestamps = true;

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
