<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'course_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // created/updated/deleted timestamps
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Add enrollment_date separately with raw SQL so CURRENT_TIMESTAMP works
        $this->forge->addField("enrollment_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

        // Status field
        $this->forge->addField([
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['enrolled', 'completed', 'dropped'],
                'default'    => 'enrolled',
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Foreign keys (reference users.id and courses.id)
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');

        // Prevent duplicate enrollment of the same user in the same course
        $this->forge->addUniqueKey(['user_id', 'course_id']);

        // Create table
        $this->forge->createTable('enrollments');
    }

    public function down()
    {
        $this->forge->dropTable('enrollments');
    }
}
