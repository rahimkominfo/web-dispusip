<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public / Front-end Routes
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('berita', 'Berita::index');
$routes->post('berita/komentar', 'Berita::tambahKomentar');
$routes->get('berita/(:segment)', 'Berita::detail/$1');
$routes->get('flyers', 'Flyers::index');
$routes->get('galeri/foto', 'Gallery::index');
$routes->get('galeri/video', 'Gallery::video');
$routes->get('page/(:segment)', 'Page::view/$1');
$routes->get('opac', 'Opac::index');
$routes->get('ipus', 'Ipus::index');

// PPID Routes
$routes->get('ppid/berkala', 'Ppid::berkala');
$routes->get('ppid/setiap_saat', 'Ppid::setiap_saat');
$routes->get('ppid/serta_merta', 'Ppid::serta_merta');
$routes->get('ppid/dikecualikan', 'Ppid::dikecualikan');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::proses');
$routes->get('logout', 'Auth::logout');

// Admin / Back-end Routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::index');
    
    // News CRUD
    $routes->get('news', 'Admin\News::index');
    $routes->get('news/create', 'Admin\News::create');
    $routes->post('news/store', 'Admin\News::store');
    $routes->get('news/edit/(:num)', 'Admin\News::edit/$1');
    $routes->post('news/update/(:num)', 'Admin\News::update/$1');
    $routes->get('news/delete/(:num)', 'Admin\News::delete/$1');

    // Comments Moderation CRUD
    $routes->get('comments', 'Admin\Comments::index');
    $routes->get('comments/approve/(:num)', 'Admin\Comments::approve/$1');
    $routes->get('comments/spam/(:num)', 'Admin\Comments::spam/$1');
    $routes->get('comments/edit/(:num)', 'Admin\Comments::edit/$1');
    $routes->post('comments/update/(:num)', 'Admin\Comments::update/$1');
    $routes->post('comments/reply/(:num)', 'Admin\Comments::reply/$1');
    $routes->get('comments/delete/(:num)', 'Admin\Comments::delete/$1');

    // Roles CRUD
    $routes->get('roles', 'Admin\Roles::index');
    $routes->get('roles/create', 'Admin\Roles::create');
    $routes->post('roles/store', 'Admin\Roles::store');
    $routes->get('roles/edit/(:num)', 'Admin\Roles::edit/$1');
    $routes->post('roles/update/(:num)', 'Admin\Roles::update/$1');
    $routes->get('roles/delete/(:num)', 'Admin\Roles::delete/$1');
    
    // Users CRUD
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Categories CRUD
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    // Tags CRUD
    $routes->get('tags', 'Admin\Tags::index');
    $routes->get('tags/create', 'Admin\Tags::create');
    $routes->post('tags/store', 'Admin\Tags::store');
    $routes->get('tags/edit/(:num)', 'Admin\Tags::edit/$1');
    $routes->post('tags/update/(:num)', 'Admin\Tags::update/$1');
    $routes->get('tags/delete/(:num)', 'Admin\Tags::delete/$1');
    
    // Running Text CRUD
    $routes->get('running-text', 'Admin\RunningText::index');
    $routes->get('running-text/create', 'Admin\RunningText::create');
    $routes->post('running-text/store', 'Admin\RunningText::store');
    $routes->get('running-text/edit/(:num)', 'Admin\RunningText::edit/$1');
    $routes->post('running-text/update/(:num)', 'Admin\RunningText::update/$1');
    $routes->get('running-text/delete/(:num)', 'Admin\RunningText::delete/$1');

    // Menu Management CRUD
    $routes->get('menus', 'Admin\Menus::index');
    $routes->get('menus/create', 'Admin\Menus::create');
    $routes->post('menus/store', 'Admin\Menus::store');
    $routes->get('menus/edit/(:num)', 'Admin\Menus::edit/$1');
    $routes->post('menus/update/(:num)', 'Admin\Menus::update/$1');
    $routes->get('menus/delete/(:num)', 'Admin\Menus::delete/$1');

    // Flyers CRUD
    $routes->get('flyers', 'Admin\Flyers::index');
    $routes->get('flyers/create', 'Admin\Flyers::create');
    $routes->post('flyers/store', 'Admin\Flyers::store');
    $routes->get('flyers/edit/(:num)', 'Admin\Flyers::edit/$1');
    $routes->post('flyers/update/(:num)', 'Admin\Flyers::update/$1');
    $routes->get('flyers/delete/(:num)', 'Admin\Flyers::delete/$1');

    // Static Pages CRUD
    $routes->get('pages', 'Admin\Pages::index');
    $routes->get('pages/create', 'Admin\Pages::create');
    $routes->post('pages/store', 'Admin\Pages::store');
    $routes->get('pages/edit/(:num)', 'Admin\Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\Pages::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\Pages::delete/$1');

    // Media Library CRUD
    $routes->get('media', 'Admin\Media::index');
    $routes->get('media/create', 'Admin\Media::create');
    $routes->post('media/store', 'Admin\Media::store');
    $routes->get('media/edit/(:num)', 'Admin\Media::edit/$1');
    $routes->post('media/update/(:num)', 'Admin\Media::update/$1');
    $routes->get('media/delete/(:num)', 'Admin\Media::delete/$1');

    // Event Gallery CRUD
    $routes->get('gallery', 'Admin\Gallery::index');
    $routes->get('gallery/create', 'Admin\Gallery::create');
    $routes->post('gallery/store', 'Admin\Gallery::store');
    $routes->get('gallery/edit/(:num)', 'Admin\Gallery::edit/$1');
    $routes->post('gallery/update/(:num)', 'Admin\Gallery::update/$1');
    $routes->get('gallery/delete/(:num)', 'Admin\Gallery::delete/$1');
    $routes->get('gallery/delete-image/(:num)/(:num)', 'Admin\Gallery::deleteImage/$1/$2');
    
    // Youtube Video CRUD
    $routes->get('youtube', 'Admin\Youtube::index');
    $routes->get('youtube/create', 'Admin\Youtube::create');
    $routes->post('youtube/store', 'Admin\Youtube::store');
    $routes->get('youtube/edit/(:num)', 'Admin\Youtube::edit/$1');
    $routes->post('youtube/update/(:num)', 'Admin\Youtube::update/$1');
    $routes->get('youtube/delete/(:num)', 'Admin\Youtube::delete/$1');

    // Comments Moderation
    $routes->get('komentar/approve/(:num)', 'Admin::approveKomentar/$1');
    $routes->get('komentar/spam/(:num)', 'Admin::spamKomentar/$1');
});
