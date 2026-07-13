<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\GaleriGambarModel;

class Gallery extends BaseController
{
    protected $galeriModel;
    protected $galeriGambarModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->galeriGambarModel = new GaleriGambarModel();
    }

    public function index()
    {
        $galleries = $this->galeriModel->orderBy('created_at', 'DESC')->findAll();

        // Calculate count of images in each gallery
        foreach ($galleries as &$gallery) {
            $gallery['image_count'] = $this->galeriGambarModel->where('galeri_id', $gallery['galeri_id'])->countAllResults();
        }

        $data = [
            'galleries' => $galleries
        ];

        return view('admin/gallery/index', $data);
    }

    public function create()
    {
        return view('admin/gallery/create');
    }

    public function store()
    {
        $rules = [
            'judul'       => 'required|min_length[3]|max_length[255]',
            'deskripsi'   => 'permit_empty',
            'sampul_url'  => 'permit_empty|max_length[255]'
        ];

        // Validate cover upload
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $sampulFile = $this->request->getFile('sampul_file');
        $hasFile = $sampulFile && $sampulFile->isValid() && !$sampulFile->hasMoved();

        if ($hasFile) {
            $ext = strtolower($sampulFile->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['sampul_file' => 'Format sampul tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($sampulFile->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['sampul_file' => 'Ukuran sampul terlalu besar. Maksimum 8MB.']);
            }
        } else {
            if (empty($this->request->getPost('sampul_url'))) {
                return redirect()->back()->withInput()->with('errors', ['sampul_file' => 'File sampul wajib diunggah.']);
            }
        }

        $sampulUrl = $this->request->getPost('sampul_url');

        // Handle cover upload
        if ($sampulFile && $sampulFile->isValid() && !$sampulFile->hasMoved()) {
            $newName = $sampulFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/gallery/covers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $sampulFile->move($uploadPath, $newName);
            $sampulUrl = base_url('uploads/gallery/covers/' . $newName);
        }

        // Save Gallery Album
        $this->galeriModel->save([
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'sampul_url' => $sampulUrl
        ]);

        $galeriId = $this->galeriModel->insertID();

        // Handle Multiple Gallery Image Uploads
        $galleryFiles = $this->request->getFiles();
        if (isset($galleryFiles['gallery_files'])) {
            $photosPath = FCPATH . 'uploads/gallery/photos';
            if (!is_dir($photosPath)) {
                mkdir($photosPath, 0755, true);
            }

            foreach ($galleryFiles['gallery_files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($photosPath, $newName);
                    $imageUrl = base_url('uploads/gallery/photos/' . $newName);

                    $this->galeriGambarModel->save([
                        'galeri_id'  => $galeriId,
                        'gambar_url' => $imageUrl,
                        'caption'    => null
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/gallery'))->with('success', 'Galeri Kegiatan berhasil dibuat.');
    }

    public function edit($id)
    {
        $gallery = $this->galeriModel->find($id);
        if (!$gallery) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Galeri tidak ditemukan.");
        }

        // Retrieve existing photos in this album
        $photos = $this->galeriGambarModel->where('galeri_id', $id)->findAll();

        $data = [
            'gallery' => $gallery,
            'photos'  => $photos
        ];

        return view('admin/gallery/edit', $data);
    }

    public function update($id)
    {
        $gallery = $this->galeriModel->find($id);
        if (!$gallery) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Galeri tidak ditemukan.");
        }

        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'deskripsi'  => 'permit_empty',
            'sampul_url' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $sampulFile = $this->request->getFile('sampul_file');
        $hasFile = $sampulFile && $sampulFile->isValid() && !$sampulFile->hasMoved();

        if ($hasFile) {
            $ext = strtolower($sampulFile->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return redirect()->back()->withInput()->with('errors', ['sampul_file' => 'Format sampul tidak didukung. Gunakan JPG, JPEG, PNG, GIF, atau WEBP.']);
            }
            if ($sampulFile->getSize() > 8388608) {
                return redirect()->back()->withInput()->with('errors', ['sampul_file' => 'Ukuran sampul terlalu besar. Maksimum 8MB.']);
            }
        }

        $sampulUrl = $this->request->getPost('sampul_url');
        if (empty($sampulUrl)) {
            $sampulUrl = $gallery['sampul_url'];
        }

        // Handle cover update
        if ($sampulFile && $sampulFile->isValid() && !$sampulFile->hasMoved()) {
            $newName = $sampulFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/gallery/covers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $sampulFile->move($uploadPath, $newName);

            // Delete old cover physically
            if (!empty($gallery['sampul_url']) && strpos($gallery['sampul_url'], base_url('uploads/gallery/covers/')) === 0) {
                $oldFilename = str_replace(base_url('uploads/gallery/covers/'), '', $gallery['sampul_url']);
                $oldFilePath = FCPATH . 'uploads/gallery/covers/' . $oldFilename;
                if (is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $sampulUrl = base_url('uploads/gallery/covers/' . $newName);
        }

        $this->galeriModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'sampul_url' => $sampulUrl
        ]);

        // Handle additional multiple gallery image uploads
        $galleryFiles = $this->request->getFiles();
        if (isset($galleryFiles['gallery_files'])) {
            $photosPath = FCPATH . 'uploads/gallery/photos';
            if (!is_dir($photosPath)) {
                mkdir($photosPath, 0755, true);
            }

            foreach ($galleryFiles['gallery_files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($photosPath, $newName);
                    $imageUrl = base_url('uploads/gallery/photos/' . $newName);

                    $this->galeriGambarModel->save([
                        'galeri_id'  => $id,
                        'gambar_url' => $imageUrl,
                        'caption'    => null
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/gallery'))->with('success', 'Galeri Kegiatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $gallery = $this->galeriModel->find($id);
        if (!$gallery) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Galeri tidak ditemukan.");
        }

        // 1. Delete cover image physically
        if (!empty($gallery['sampul_url']) && strpos($gallery['sampul_url'], base_url('uploads/gallery/covers/')) === 0) {
            $coverFilename = str_replace(base_url('uploads/gallery/covers/'), '', $gallery['sampul_url']);
            $coverFilePath = FCPATH . 'uploads/gallery/covers/' . $coverFilename;
            if (is_file($coverFilePath)) {
                unlink($coverFilePath);
            }
        }

        // 2. Delete all photos physically & database records
        $photos = $this->galeriGambarModel->where('galeri_id', $id)->findAll();
        foreach ($photos as $photo) {
            if (!empty($photo['gambar_url']) && strpos($photo['gambar_url'], base_url('uploads/gallery/photos/')) === 0) {
                $photoFilename = str_replace(base_url('uploads/gallery/photos/'), '', $photo['gambar_url']);
                $photoFilePath = FCPATH . 'uploads/gallery/photos/' . $photoFilename;
                if (is_file($photoFilePath)) {
                    unlink($photoFilePath);
                }
            }
            $this->galeriGambarModel->delete($photo['galeri_gambar_id']);
        }

        // 3. Delete gallery record
        $this->galeriModel->delete($id);

        return redirect()->to(base_url('admin/gallery'))->with('success', 'Galeri Kegiatan beserta seluruh fotonya berhasil dihapus.');
    }

    public function deleteImage($galleryId, $imageId)
    {
        $photo = $this->galeriGambarModel->where('galeri_gambar_id', $imageId)
                                         ->where('galeri_id', $galleryId)
                                         ->first();

        if ($photo) {
            // Delete physical file
            if (!empty($photo['gambar_url']) && strpos($photo['gambar_url'], base_url('uploads/gallery/photos/')) === 0) {
                $filename = str_replace(base_url('uploads/gallery/photos/'), '', $photo['gambar_url']);
                $filePath = FCPATH . 'uploads/gallery/photos/' . $filename;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $this->galeriGambarModel->delete($imageId);
            return redirect()->to(base_url('admin/gallery/edit/' . $galleryId))->with('success', 'Foto berhasil dihapus dari galeri.');
        }

        return redirect()->to(base_url('admin/gallery/edit/' . $galleryId))->with('errors', ['delete' => 'Foto tidak ditemukan.']);
    }
}
