<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pendaftaran' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'id_kegiatan' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // Biodata peserta
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'nama_panggilan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'no_whatsapp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'instagram' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'instansi' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'domisili' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'riwayat_penyakit' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Persyaratan tambahan per kegiatan
            'data_persyaratan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'berkas_persyaratan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Pembayaran
            'jumlah_pembayaran' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'tidak_ada',
            ],

            // Status pendaftaran
            'status_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'menunggu_verifikasi',
            ],
            'catatan_admin' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('id_pendaftaran', true);
        $this->forge->addUniqueKey('kode_pendaftaran');
        $this->forge->addKey('id_kegiatan');
        $this->forge->addKey('email');
        $this->forge->addKey('status_pendaftaran');
        $this->forge->addKey('status_pembayaran');

        $this->forge->addForeignKey(
            'id_kegiatan',
            'kegiatan',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran', true);
    }
}
