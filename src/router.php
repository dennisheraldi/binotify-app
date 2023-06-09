<?php
// DO NOT CHANGE =====
namespace MusicApp;

use MusicApp\Controllers\AuthController;
use MusicApp\Controllers\HomeController;
use MusicApp\Controllers\DaftarUserController;
use MusicApp\Controllers\LaguController;
use MusicApp\Controllers\AlbumController;
use MusicApp\Controllers\SearchController;
use MusicApp\Controllers\PenyanyiController;
use MusicApp\Controllers\WebhookController;
use MusicApp\Core\Route;

use function MusicApp\Core\redirect;

// ===================

// Import controller here


// Define routes here
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/user', [DaftarUserController::class, 'user'])->name('user');
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/check/username/:username', [AuthController::class, 'checkUsername']);
Route::post('/check/email/:email', [AuthController::class, 'checkEmail']);
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::post('/webhook/subscribe/:creator_id/:subscriber_id', [WebhookController::class, 'subscribe']);
Route::group('/lagu', function() {
    Route::post('/', [LaguController::class, 'store']);
    Route::get('/create', [LaguController::class, 'create'])->name('lagu.tambah');
    Route::get('/:id', [LaguController::class, 'show'])->name('lagu.detail');
    Route::post('/:id', [LaguController::class, 'update']);
    Route::post('/:id/delete', [LaguController::class, 'delete']);
});
Route::group('album', function() {
    Route::get('/', [AlbumController::class, 'daftarAlbum'])->name('album.daftar-album');
    Route::get('/data', [AlbumController::class, 'showListAlbum'])->name('album.show-list-album');
    Route::get('/create', [AlbumController::class, 'formAlbum'])->name('album.form-album');
    Route::post('/add/:album_id/:song_id', [AlbumController::class, 'tambahLagu'])->name('album.tambah-lagu');
    Route::post('/create', [AlbumController::class, 'tambahAlbum']);
    Route::get('/add/:album_id', [AlbumController::class, 'formLagu'])->name('album.form-lagu');
    Route::post('/:album_id/delete', [AlbumController::class, 'hapusAlbum']);
    Route::post('/:album_id/delete/:song_id', [AlbumController::class, 'hapusLagu']);
    Route::get('/:id', [AlbumController::class, 'detailAlbum'])->name('album.detail-album');
    Route::post('/:album_id', [AlbumController::class, 'changeData']);
});
Route::group('penyanyi', function() {
    Route::get('/', [PenyanyiController::class, 'listPenyanyi'])->name('penyanyi.list-penyanyi');
    Route::post('/:id', [PenyanyiController::class, 'Subscribe']);
    Route::get('/:penyanyi', [PenyanyiController::class, 'listLagu'])->name('penyanyi.list-lagu');
});
Route::default(function() {
    return redirect('/');
});
?>