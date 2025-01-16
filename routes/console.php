<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    // A l'interior d'una comanda, pots utilitzar $this per accedir als mètodes com 'comment' o 'line'.
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
