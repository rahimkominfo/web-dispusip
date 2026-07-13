<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menus extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        // Join self to display parent menu title if available
        $menus = $this->menuModel->select('mst_menu.*, parent.title as parent_title')
                                 ->join('mst_menu parent', 'parent.id = mst_menu.parent_id', 'left')
                                 ->orderBy('mst_menu.sort_order', 'ASC')
                                 ->findAll();

        $data = [
            'menus' => $menus
        ];

        return view('admin/menus/index', $data);
    }

    public function create()
    {
        // Retrieve potential parent menus (top-level menus with no parent_id)
        $parentMenus = $this->menuModel->where('parent_id', null)->findAll();

        $data = [
            'parentMenus' => $parentMenus
        ];

        return view('admin/menus/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'      => 'required|min_length[2]|max_length[100]',
            'url'        => 'required|max_length[255]',
            'sort_order' => 'required|integer',
            'is_active'  => 'required|in_list[0,1]',
            'parent_id'  => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parentId = $this->request->getPost('parent_id');
        $parentId = ($parentId === '' || $parentId === '0') ? null : $parentId;

        $this->menuModel->save([
            'parent_id'  => $parentId,
            'title'      => $this->request->getPost('title'),
            'url'        => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active')
        ]);

        return redirect()->to(base_url('admin/menus'))->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Menu tidak ditemukan.");
        }

        // Retrieve potential parent menus (excluding self to avoid hierarchy loops)
        $parentMenus = $this->menuModel->where('parent_id', null)
                                       ->where('id !=', $id)
                                       ->findAll();

        $data = [
            'menu'        => $menu,
            'parentMenus' => $parentMenus
        ];

        return view('admin/menus/edit', $data);
    }

    public function update($id)
    {
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Menu tidak ditemukan.");
        }

        $rules = [
            'title'      => 'required|min_length[2]|max_length[100]',
            'url'        => 'required|max_length[255]',
            'sort_order' => 'required|integer',
            'is_active'  => 'required|in_list[0,1]',
            'parent_id'  => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parentId = $this->request->getPost('parent_id');
        $parentId = ($parentId === '' || $parentId === '0') ? null : $parentId;

        // Prevent setting self as parent
        if ($parentId == $id) {
            return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Menu tidak dapat menjadi induk dari dirinya sendiri.']);
        }

        $this->menuModel->update($id, [
            'parent_id'  => $parentId,
            'title'      => $this->request->getPost('title'),
            'url'        => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active')
        ]);

        return redirect()->to(base_url('admin/menus'))->with('success', 'Menu berhasil diperbarui.');
    }

    public function delete($id)
    {
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Menu tidak ditemukan.");
        }

        // Set child menus' parent_id to null before deleting the parent menu
        $this->menuModel->where('parent_id', $id)->set(['parent_id' => null])->update();

        $this->menuModel->delete($id);

        return redirect()->to(base_url('admin/menus'))->with('success', 'Menu berhasil dihapus.');
    }
}
