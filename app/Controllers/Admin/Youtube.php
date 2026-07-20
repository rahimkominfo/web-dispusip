<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\YoutubeModel;

class Youtube extends BaseController
{
    protected $youtubeModel;

    public function __construct()
    {
        $this->youtubeModel = new YoutubeModel();
        helper('url');
    }

    public function index()
    {
        $videos = $this->youtubeModel->findAll();

        $data = [
            'videos' => $videos
        ];

        return view('admin/youtube/index', $data);
    }

    public function create()
    {
        return view('admin/youtube/create');
    }

    public function store()
    {
        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'youtube_id' => 'required|min_length[5]|max_length[100]',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $youtubeId = $this->request->getPost('youtube_id');
        $cleanId = $this->extractYoutubeId($youtubeId);

        $this->youtubeModel->save([
            'judul'      => $this->request->getPost('judul'),
            'youtube_id' => $cleanId,
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/youtube'))->with('success', 'Video YouTube berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $video = $this->youtubeModel->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Video YouTube tidak ditemukan.");
        }

        $data = [
            'video' => $video
        ];

        return view('admin/youtube/edit', $data);
    }

    public function update($id)
    {
        $video = $this->youtubeModel->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Video YouTube tidak ditemukan.");
        }

        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'youtube_id' => 'required|min_length[5]|max_length[100]',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $youtubeId = $this->request->getPost('youtube_id');
        $cleanId = $this->extractYoutubeId($youtubeId);

        $this->youtubeModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'youtube_id' => $cleanId,
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status')
        ]);

        return redirect()->to(base_url('admin/youtube'))->with('success', 'Video YouTube berhasil diperbarui.');
    }

    public function delete($id)
    {
        $video = $this->youtubeModel->find($id);
        if (!$video) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Video YouTube tidak ditemukan.");
        }

        $this->youtubeModel->delete($id);

        return redirect()->to(base_url('admin/youtube'))->with('success', 'Video YouTube berhasil dihapus.');
    }

    /**
     * Extracts YouTube Video ID from various YouTube URL formats.
     */
    private function extractYoutubeId($urlOrId)
    {
        // If it's already just an ID (contains no slashes or dots)
        if (!preg_match('/[\/\.]/', $urlOrId)) {
            return trim($urlOrId);
        }

        // Handle various YouTube URL formats:
        // https://www.youtube.com/watch?v=VIDEO_ID
        // https://youtu.be/VIDEO_ID
        // https://www.youtube.com/embed/VIDEO_ID
        // https://www.youtube.com/v/VIDEO_ID
        // https://music.youtube.com/watch?v=VIDEO_ID
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        if (preg_match($pattern, $urlOrId, $matches)) {
            return $matches[1];
        }

        return trim($urlOrId);
    }
}
