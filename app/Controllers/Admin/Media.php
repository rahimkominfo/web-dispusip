<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MediaModel;
use App\Models\UserModel;

class Media extends BaseController
{
    protected $mediaModel;
    protected $userModel;

    public function __construct()
    {
        $this->mediaModel = new MediaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $cari = $this->request->getGet('cari');

        $this->mediaModel->select('mst_media.*, sys_users.nama_publik as uploader')
                         ->join('sys_users', 'sys_users.user_id = mst_media.user_id', 'left');

        if (!empty($cari)) {
            $this->mediaModel->groupStart()
                             ->like('mst_media.nama_file', $cari)
                             ->orLike('mst_media.caption', $cari)
                             ->orLike('mst_media.tipe_file', $cari)
                             ->orLike('sys_users.nama_publik', $cari)
                             ->groupEnd();
        }

        $media = $this->mediaModel->orderBy('mst_media.created_at', 'DESC')->paginate(10, 'default');

        $data = [
            'media' => $media,
            'pager' => $this->mediaModel->pager,
            'cari'  => $cari
        ];

        return view('admin/media/index', $data);
    }

    public function create()
    {
        return view('admin/media/create');
    }

    public function store()
    {
        $rules = [
            'caption'      => 'permit_empty|max_length[255]',
            'media_file'   => 'uploaded[media_file]|max_size[media_file,8192]' // Max 8MB
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('media_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $originalName = $file->getClientName();
            $mimeType = $file->getClientMimeType();
            $newName = $file->getRandomName();
            
            $uploadPath = FCPATH . 'uploads/media';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);
            
            $urlFile = base_url('uploads/media/' . $newName);
            $userId = session()->get('user_id') ?: 1; // Fallback to Admin (ID 1)

            $this->mediaModel->save([
                'nama_file' => $originalName,
                'url_file'  => $urlFile,
                'tipe_file' => $mimeType,
                'caption'   => $this->request->getPost('caption'),
                'user_id'   => $userId
            ]);

            return redirect()->to(base_url('admin/media'))->with('success', 'Berkas media berhasil diunggah.');
        }

        return redirect()->back()->withInput()->with('errors', ['media_file' => 'Berkas tidak valid atau gagal diunggah.']);
    }

    public function edit($id)
    {
        $media = $this->mediaModel->find($id);
        if (!$media) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berkas media tidak ditemukan.");
        }

        $data = [
            'media' => $media
        ];

        return view('admin/media/edit', $data);
    }

    public function update($id)
    {
        $media = $this->mediaModel->find($id);
        if (!$media) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berkas media tidak ditemukan.");
        }

        $rules = [
            'caption'    => 'permit_empty|max_length[255]',
            'media_file' => 'permit_empty|max_size[media_file,8192]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $urlFile = $media['url_file'];
        $originalName = $media['nama_file'];
        $mimeType = $media['tipe_file'];

        $file = $this->request->getFile('media_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $originalName = $file->getClientName();
            $mimeType = $file->getClientMimeType();
            $newName = $file->getRandomName();
            
            $uploadPath = FCPATH . 'uploads/media';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $newName);
            
            // Delete old physical file if it exists locally
            if (!empty($media['url_file']) && strpos($media['url_file'], base_url('uploads/media/')) === 0) {
                $oldFilename = str_replace(base_url('uploads/media/'), '', $media['url_file']);
                $oldFilePath = FCPATH . 'uploads/media/' . $oldFilename;
                if (is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $urlFile = base_url('uploads/media/' . $newName);
        }

        $this->mediaModel->update($id, [
            'nama_file' => $originalName,
            'url_file'  => $urlFile,
            'tipe_file' => $mimeType,
            'caption'   => $this->request->getPost('caption')
        ]);

        return redirect()->to(base_url('admin/media'))->with('success', 'Berkas media berhasil diperbarui.');
    }

    public function delete($id)
    {
        $media = $this->mediaModel->find($id);
        if (!$media) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berkas media tidak ditemukan.");
        }

        // Delete physical file
        if (!empty($media['url_file']) && strpos($media['url_file'], base_url('uploads/media/')) === 0) {
            $filename = str_replace(base_url('uploads/media/'), '', $media['url_file']);
            $filePath = FCPATH . 'uploads/media/' . $filename;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }

        $this->mediaModel->delete($id);

        return redirect()->to(base_url('admin/media'))->with('success', 'Berkas media berhasil dihapus.');
    }
}
