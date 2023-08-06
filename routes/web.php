<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\SearchController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {

        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['verified'])->name('dashboard');

        Route::get('/dashboard', [PainelController::class, 'index'])->middleware(['verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('/profile/{id}', [ProfileController::class, 'updatezip'])->name('profile.zip');

        Route::get('/contact', [ContactsController::class, 'edit'])->name('contact');

        Route::get('/document', [DocumentsController::class, 'new'])->name('documents.new');
        Route::post('/document', [DocumentsController::class, 'create'])->name('documents.create');
        Route::get('/search', [DocumentsController::class, 'index'])->name('search');
        Route::get('/document/{id}', [DocumentsController::class, 'show'])->name('documents.show');
        Route::put('/document/{id}', [DocumentsController::class, 'store'])->name('documents.store');
        Route::get('/view/{id}', [DocumentsController::class, 'view'])->name('documents.files');
        Route::get('/download/{id}', [DocumentsController::class, 'download'])->name('documents.download');
        Route::post('/document/{id}', [DocumentsController::class, 'upload'])->name('documents.upload');
        Route::get('/delete-file/{id}/{nomearq}', [DocumentsController::class, 'deleteFile'])->name('documents.deletefile');


        Route::get('/delete/{id}', [DocumentsController::class, 'delete'])->name('documents.delete');
        Route::delete('/document-destroy/{id}', [DocumentsController::class, 'destroy'])->name('documents.destroy');
        
    });

    require __DIR__.'/auth.php';
});
