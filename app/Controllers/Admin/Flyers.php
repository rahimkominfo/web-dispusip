<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FlyerModel;

class Flyers extends BaseController
{
    protected $flyerModel;

    public function __construct()
    {
        $this->flyerModel = new FlyerModel();
    }

    public function index()
    {
        $flyers = $this->flyerModel->orderBy('urutan', 'ASC')->findAll();

        $data = [
            'flyers' => $flyers
        ];

        return view('admin/flyers/index', $data);
    }

    public function create()
    {
        return view('admin/flyers/create');
    }

    public function store()
    {
        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'label'      => 'permit_empty|max_length[100]',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]',
            'urutan'     => 'required|integer',
            'gambar_url' => 'permit_empty|max_length[255]'
        ];

        // Check if an image file is uploaded
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar_file');
        $hasFile = $file && $file->isValid() && !$file->hasMoved();

        if ($hasFile) {
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['gambar_file' => 'Format gambar tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($file->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['gambar_file' => 'Ukuran gambar terlalu besar. Maksimum 8MB.']);
            }
        } else {
            if (empty($this->request->getPost('gambar_url'))) {
                return redirect()->back()->withInput()->with('errors', ['gambar_file' => 'File gambar wajib diunggah.']);
            }
        }

        $gambarUrl = $this->request->getPost('gambar_url');

        // Handle File Upload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/flyers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);
            $gambarUrl = base_url('uploads/flyers/' . $newName);
        }

        // Generate UUID v4
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $this->flyerModel->save([
            'uuid'       => $uuid,
            'judul'      => $this->request->getPost('judul'),
            'label'      => $this->request->getPost('label'),
            'status'     => $this->request->getPost('status'),
            'urutan'     => $this->request->getPost('urutan'),
            'gambar_url' => $gambarUrl
        ]);

        return redirect()->to(base_url('admin/flyers'))->with('success', 'Banner/Flyer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $flyer = $this->flyerModel->find($id);
        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Banner/Flyer tidak ditemukan.");
        }

        $data = [
            'flyer' => $flyer
        ];

        return view('admin/flyers/edit', $data);
    }

    public function update($id)
    {
        $flyer = $this->flyerModel->find($id);
        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Banner/Flyer tidak ditemukan.");
        }

        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'label'      => 'permit_empty|max_length[100]',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]',
            'urutan'     => 'required|integer',
            'gambar_url' => 'permit_empty|max_length[255]'
        ];

        // Validate uploaded file if present
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar_file');
        $hasFile = $file && $file->isValid() && !$file->hasMoved();

        if ($hasFile) {
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['gambar_file' => 'Format gambar tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($file->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['gambar_file' => 'Ukuran gambar terlalu besar. Maksimum 8MB.']);
            }
        }

        $gambarUrl = $this->request->getPost('gambar_url');
        if (empty($gambarUrl)) {
            $gambarUrl = $flyer['gambar_url'];
        }

        // Handle File Upload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/flyers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);
            
            // Delete old file if it was uploaded locally
            if (!empty($flyer['gambar_url']) && strpos($flyer['gambar_url'], base_url('uploads/flyers/')) === 0) {
                $oldFilename = str_replace(base_url('uploads/flyers/'), '', $flyer['gambar_url']);
                $oldFilePath = FCPATH . 'uploads/flyers/' . $oldFilename;
                if (is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $gambarUrl = base_url('uploads/flyers/' . $newName);
        }

        $this->flyerModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'label'      => $this->request->getPost('label'),
            'status'     => $this->request->getPost('status'),
            'urutan'     => $this->request->getPost('urutan'),
            'gambar_url' => $gambarUrl
        ]);

        return redirect()->to(base_url('admin/flyers'))->with('success', 'Banner/Flyer berhasil diperbarui.');
    }

    public function delete($id)
    {
        $flyer = $this->flyerModel->find($id);
        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Banner/Flyer tidak ditemukan.");
        }

        // Delete uploaded file if it was uploaded locally
        if (!empty($flyer['gambar_url']) && strpos($flyer['gambar_url'], base_url('uploads/flyers/')) === 0) {
            $filename = str_replace(base_url('uploads/flyers/'), '', $flyer['gambar_url']);
            $filePath = FCPATH . 'uploads/flyers/' . $filename;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }

        $this->flyerModel->delete($id);

        return redirect()->to(base_url('admin/flyers'))->with('success', 'Banner/Flyer berhasil dihapus.');
    }
}
