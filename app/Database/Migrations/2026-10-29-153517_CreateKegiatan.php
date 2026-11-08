<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKegiatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'aktif' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'kuota' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 30,
            ],
            'batas_pendaftaran' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'jenis_biaya' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'gratis',
            ],
            'biaya_pendaftaran' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'status_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'dibuka',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('kegiatan', true);
    }
}
