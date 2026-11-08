<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatistikTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'relawan' => [
                'type'       => 'INT',
                'constraint' => 10,
                'default'    => 0,
            ],
            'organisasi' => [
                'type'       => 'INT',
                'constraint' => 10,
                'default'    => 0,
            ],
            'aktivitas_sosial' => [
                'type'       => 'INT',
                'constraint' => 10,
                'default'    => 0,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('statistik');
    }

    public function down()
    {
        $this->forge->dropTable('statistik');
    }
}