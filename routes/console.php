<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Agendar limpeza de empréstimos antigos no dia 1 de cada mês
Schedule::command('emprestimos:limpar')->monthlyOn(1, '00:00');
