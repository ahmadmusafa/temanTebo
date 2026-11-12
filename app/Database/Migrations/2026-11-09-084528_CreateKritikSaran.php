<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKritikSaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'jenis'      => ['type' => 'ENUM', 'constraint' => ['kritik', 'saran'], 'default' => 'saran'],
            'pesan'      => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kritik_saran');
    }

    public function down()
    {
        $this->forge->dropTable('kritik_saran');
    }
}