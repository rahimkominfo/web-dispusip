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

        $hierarchicalMenus = $this->buildHierarchicalList($menus);
        
        // Find any menus that might have been left out (fallback/just in case)
        $includedIds = array_column($hierarchicalMenus, 'id');
        $leftovers = [];
        foreach ($menus as $m) {
            if (!in_array($m['id'], $includedIds)) {
                $m['depth'] = 0;
                $leftovers[] = $m;
            }
        }
        
        if (!empty($leftovers)) {
            $hierarchicalMenus = array_merge($hierarchicalMenus, $leftovers);
        }

        $data = [
            'menus' => $hierarchicalMenus
        ];

        return view('admin/menus/index', $data);
    }

    public function create()
    {
        // Retrieve all menus to determine their depth
        $allMenus = $this->menuModel->orderBy('sort_order', 'ASC')->findAll();
        
        $menusById = [];
        foreach ($allMenus as $menu) {
            $menusById[$menu['id']] = $menu;
        }

        // Filter potential parent menus: depth <= 1 (Level 1 or Level 2 menus)
        $parentMenus = [];
        foreach ($allMenus as $menu) {
            if ($this->getDepth($menu['id'], $menusById) <= 1) {
                $parentMenus[] = $menu;
            }
        }

        // Sort parent menus hierarchically
        $parentMenus = $this->buildHierarchicalList($parentMenus);

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

        if ($parentId !== null) {
            $parentMenu = $this->menuModel->find($parentId);
            if (!$parentMenu) {
                return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Menu induk tidak ditemukan.']);
            }
            
            // Get all menus to check parent's depth
            $allMenus = $this->menuModel->findAll();
            $menusById = [];
            foreach ($allMenus as $m) {
                $menusById[$m['id']] = $m;
            }
            
            if ($this->getDepth($parentId, $menusById) > 1) {
                return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Menu induk tidak boleh berupa sub-sub-menu (maksimal 3 level).']);
            }
        }

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

        // Get all menus
        $allMenus = $this->menuModel->orderBy('sort_order', 'ASC')->findAll();
        
        $menusById = [];
        foreach ($allMenus as $m) {
            $menusById[$m['id']] = $m;
        }

        // Calculate max descendant depth offset for the current menu
        $maxOffset = $this->getMaxDescendantDepthOffset($id, $allMenus);

        // Filter potential parent menus
        $parentMenus = [];
        foreach ($allMenus as $m) {
            // 1. Cannot be self or descendant
            if ($this->isDescendantOrSelf($id, $m['id'], $allMenus)) {
                continue;
            }

            // 2. Depth constraint: depth(P) <= 1 - maxOffset
            $pDepth = $this->getDepth($m['id'], $menusById);
            if ($pDepth <= (1 - $maxOffset)) {
                $parentMenus[] = $m;
            }
        }

        // Sort hierarchically
        $parentMenus = $this->buildHierarchicalList($parentMenus);

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

        if ($parentId !== null) {
            // Prevent setting self as parent
            if ($parentId == $id) {
                return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Menu tidak dapat menjadi induk dari dirinya sendiri.']);
            }

            $allMenus = $this->menuModel->findAll();
            
            // Prevent setting descendant as parent (avoid circular reference)
            if ($this->isDescendantOrSelf($id, $parentId, $allMenus)) {
                return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Menu induk tidak boleh berupa sub-menu dari menu ini sendiri.']);
            }

            // Depth validation
            $menusById = [];
            foreach ($allMenus as $m) {
                $menusById[$m['id']] = $m;
            }
            $pDepth = $this->getDepth($parentId, $menusById);
            $maxOffset = $this->getMaxDescendantDepthOffset($id, $allMenus);

            if ($pDepth > (1 - $maxOffset)) {
                return redirect()->back()->withInput()->with('errors', ['parent_id' => 'Struktur menu terlalu dalam. Maksimal struktur menu adalah 3 level.']);
            }
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

    /**
     * Get the depth of a menu item.
     * Level 1 (Root) = 0
     * Level 2 (Sub) = 1
     * Level 3 (Sub-sub) = 2
     */
    private function getDepth($menuId, array $menusById)
    {
        $depth = 0;
        $currentId = $menuId;
        while ($currentId !== null && isset($menusById[$currentId])) {
            $parentId = $menusById[$currentId]['parent_id'];
            if ($parentId === null) {
                break;
            }
            $depth++;
            $currentId = $parentId;
        }
        return $depth;
    }

    /**
     * Get the maximum depth offset of any descendant of a menu item.
     * If no children: returns 0
     * If has children but no grandchildren: returns 1
     * If has grandchildren: returns 2
     */
    private function getMaxDescendantDepthOffset($menuId, array $menus)
    {
        $maxOffset = 0;
        foreach ($menus as $m) {
            if ($m['parent_id'] == $menuId) {
                $maxOffset = max($maxOffset, 1 + $this->getMaxDescendantDepthOffset($m['id'], $menus));
            }
        }
        return $maxOffset;
    }

    /**
     * Check if menu B is a descendant of menu A (or is menu A itself)
     */
    private function isDescendantOrSelf($menuId, $targetId, array $menus)
    {
        if ($menuId == $targetId) {
            return true;
        }
        foreach ($menus as $m) {
            if ($m['parent_id'] == $menuId) {
                if ($this->isDescendantOrSelf($m['id'], $targetId, $menus)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Build hierarchical list of menus
     */
    private function buildHierarchicalList(array $menus, $parentId = null, $depth = 0)
    {
        $branch = [];
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parentId) {
                $menu['depth'] = $depth;
                $branch[] = $menu;
                $children = $this->buildHierarchicalList($menus, $menu['id'], $depth + 1);
                if ($children) {
                    $branch = array_merge($branch, $children);
                }
            }
        }
        return $branch;
    }
}
