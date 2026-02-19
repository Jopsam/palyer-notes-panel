<?php

use App\Livewire\Players\Index as PlayersIndex;
use App\Livewire\Players\Notes as PlayerNotes;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('players.index');
});

Route::middleware(['auth', 'agent-viewer'])->group(function () {
    // Dashboard and profile routes.
    Route::view('profile', 'profile')->name('profile');
    
    // Player routes.
    Route::get('/players', PlayersIndex::class)->name('players.index');
    Route::get('/players/{id}/notes', PlayerNotes::class)->name('players.notes');
});
