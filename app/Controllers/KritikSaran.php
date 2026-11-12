<?php

namespace App\Controllers;

use App\Models\KritikSaranModel;

class KritikSaran extends BaseController
{
    public function kirim()
    {
        // Honeypot anti-bot
        if ((string) $this->request->getPost('website') !== '') {
            return redirect()->to(site_url('/#kritik-saran'))
                ->with('kritik_sukses', 'Terima kasih!');
        }

        $data = [
            'nama'  => trim((string) $this->request->getPost('nama')),
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'jenis' => (string) $this->request->getPost('jenis'),
            'pesan' => trim((string) $this->request->getPost('pesan')),
        ];

        $model = new KritikSaranModel();

        if (! $model->insert($data)) {
            return redirect()->to(site_url('/#kritik-saran'))
                ->withInput()
                ->with('errors_kritik', $model->errors())
                ->with('kritik_gagal', 'Mohon periksa kembali isian Anda.');
        }

        return redirect()->to(site_url('/#kritik-saran'))
            ->with('kritik_sukses', 'Terima kasih! Kritik/saran Anda sudah terkirim.');
    }
}