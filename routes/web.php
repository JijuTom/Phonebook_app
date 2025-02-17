<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return redirect('contacts');
});

Route::resource('contacts', ContactController::class);
Route::post('/contacts/import-xml', [ContactController::class, 'readXML'])->name('contacts.read.xml');

