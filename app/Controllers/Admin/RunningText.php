<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RunningTextModel;

class RunningText extends BaseController
{
    protected $runningTextModel;

    public function __construct()
    {
        $this->runningTextModel = new RunningTextModel();
    }

    public function index()
    {
        $runningTexts = $this->runningTextModel->findAll();

        $data = [
            'runningTexts' => $runningTexts
        ];

        return view('admin/running_text/index', $data);
    }

    public function create()
    {
        return view('admin/running_text/create');
    }

    public function store()
    {
        $rules = [
            'teks'      => 'required|min_length[3]',
            'is_active' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->runningTextModel->save([
            'teks'      => $this->request->getPost('teks'),
            'is_active' => $this->request->getPost('is_active')
        ]);

        return redirect()->to(base_url('admin/running-text'))->with('success', 'Running text berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $runningText = $this->runningTextModel->find($id);
        if (!$runningText) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Running text tidak ditemukan.");
        }

        $data = [
            'runningText' => $runningText
        ];

        return view('admin/running_text/edit', $data);
    }

    public function update($id)
    {
        $runningText = $this->runningTextModel->find($id);
        if (!$runningText) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Running text tidak ditemukan.");
        }

        $rules = [
            'teks'      => 'required|min_length[3]',
            'is_active' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->runningTextModel->update($id, [
            'teks'      => $this->request->getPost('teks'),
            'is_active' => $this->request->getPost('is_active')
        ]);

        return redirect()->to(base_url('admin/running-text'))->with('success', 'Running text berhasil diperbarui.');
    }

    public function delete($id)
    {
        $runningText = $this->runningTextModel->find($id);
        if (!$runningText) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Running text tidak ditemukan.");
        }

        $this->runningTextModel->delete($id);

        return redirect()->to(base_url('admin/running-text'))->with('success', 'Running text berhasil dihapus.');
    }
}
