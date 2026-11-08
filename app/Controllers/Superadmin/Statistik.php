<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\StatistikModel;

class Statistik extends BaseController
{
    protected StatistikModel $statistikModel;

    public function __construct()
    {
        $this->statistikModel = new StatistikModel();
    }

    public function index()
    {
        // Ambil data statistik pertama
        $statistik = $this->statistikModel->first();

        // Buat data awal jika tabel masih kosong
        if ($statistik === null) {
            $id = $this->statistikModel->insert([
                'relawan'          => 0,
                'organisasi'       => 0,
                'aktivitas_sosial' => 0,
            ]);

            $statistik = $this->statistikModel->find($id);
        }

        return view('superadmin/statistik/index', [
            'title'     => 'Kelola Statistik',
            'statistik' => $statistik,
        ]);
    }

    public function update()
    {
        $rules = [
            'relawan' => 'required|integer|greater_than_equal_to[0]',
            'organisasi' => 'required|integer|greater_than_equal_to[0]',
            'aktivitas_sosial' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $statistik = $this->statistikModel->first();

        if ($statistik === null) {
            return redirect()->back()
                ->with('error', 'Data statistik belum tersedia.');
        }

        $this->statistikModel->update($statistik['id'], [
            'relawan'          => $this->request->getPost('relawan'),
            'organisasi'       => $this->request->getPost('organisasi'),
            'aktivitas_sosial' => $this->request->getPost('aktivitas_sosial'),
        ]);

        return redirect()->to('/superadmin/statistik')
            ->with('success', 'Statistik berhasil diperbarui.');
    }
}
