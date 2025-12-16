<?php

namespace App\Console\Commands;

use App\Models\Emprestimo;
use Illuminate\Console\Command;
use Carbon\Carbon;

class LimparEmprestimosAntigos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emprestimos:limpar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove os registros de empréstimos devolvidos do mês anterior';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpeza de empréstimos antigos...');

        // Pega o primeiro dia do mês atual
        $inicioMesAtual = Carbon::now()->startOfMonth();

        // Deleta empréstimos devolvidos que são anteriores ao mês atual
        $deletados = Emprestimo::where('devolvido', true)
            ->where('data_emprestimo', '<', $inicioMesAtual)
            ->delete();

        $this->info("✓ {$deletados} registro(s) de empréstimos antigos removido(s).");

        // Log opcional
        if ($deletados > 0) {
            \Log::info("Limpeza de empréstimos: {$deletados} registros removidos em " . now()->format('d/m/Y H:i'));
        }

        return Command::SUCCESS;
    }
}
