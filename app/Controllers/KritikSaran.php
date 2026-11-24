<?php

namespace App\Controllers;

use App\Models\KritikSaranModel;

class KritikSaran extends BaseController
{
    public function kirim()
    {
        // Honeypot anti-bot
        if ((string) $this->request->getPost('website') !== '') {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Terima kasih! Kritik/saran Anda sudah terkirim.',
            ]);
        }

        $data = [
            'nama'  => trim((string) $this->request->getPost('nama')),
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'jenis' => (string) $this->request->getPost('jenis'),
            'pesan' => trim((string) $this->request->getPost('pesan')),
        ];

        $model = new KritikSaranModel();

        if (! $model->insert($data)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Mohon periksa kembali isian Anda.',
                    'errors'  => $model->errors(),
                ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Terima kasih! Kritik/saran Anda sudah terkirim.',
        ]);
    }
}
