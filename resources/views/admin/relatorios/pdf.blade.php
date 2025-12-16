<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Patrimônios - UNIVC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        
        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 3px solid #16a34a;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #16a34a;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 12px;
        }
        
        .filters {
            background: #f3f4f6;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .filters p {
            margin: 3px 0;
        }
        
        .filters strong {
            color: #16a34a;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #16a34a;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .situacao {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .situacao-disponivel { background: #dcfce7; color: #166534; }
        .situacao-manutencao { background: #fef3c7; color: #92400e; }
        .situacao-emprestado { background: #dbeafe; color: #1e40af; }
        .situacao-descartado { background: #fee2e2; color: #991b1b; }
        .situacao-separado_descarte { background: #ffedd5; color: #9a3412; }
        
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #666;
            font-size: 10px;
        }
        
        .total {
            text-align: right;
            padding: 10px;
            font-weight: bold;
            color: #16a34a;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Relatório de Patrimônios</h1>
        <p>Sistema de Gestão de Patrimônios - UNIVC</p>
        <p>Gerado em: {{ date('d/m/Y H:i') }}</p>
    </div>
    
    <div class="filters">
        <p><strong>Filtros aplicados:</strong></p>
        <p>Tipo: {{ $filtros['tipo'] }} | Local: {{ $filtros['local'] }} | Situação: {{ $filtros['situacao'] }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">Código</th>
                <th>Patrimônio</th>
                <th style="width: 120px;">Tipo</th>
                <th style="width: 120px;">Local</th>
                <th style="width: 100px;">Situação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patrimonios as $patrimonio)
                <tr>
                    <td><strong>{{ $patrimonio->codigo_barra }}</strong></td>
                    <td>{{ $patrimonio->nome }}</td>
                    <td>{{ $patrimonio->tipoPatrimonio?->nome ?? '-' }}</td>
                    <td>{{ $patrimonio->localArmazenamento?->nome ?? '-' }}</td>
                    <td>
                        <span class="situacao situacao-{{ $patrimonio->situacao }}">
                            {{ $patrimonio->situacao_label }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px;">
                        Nenhum patrimônio encontrado com os filtros selecionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <p class="total">Total de registros: {{ $patrimonios->count() }}</p>
    
    @if($emprestimosDoMes->count() > 0)
    <!-- Seção de Empréstimos do Mês -->
    <div style="page-break-before: auto; margin-top: 30px;">
        <div style="background: #fef3c7; padding: 10px 15px; margin-bottom: 15px; border-radius: 5px; border-left: 4px solid #f59e0b;">
            <h2 style="color: #92400e; font-size: 16px; margin: 0;">
                📦 Empréstimos do Mês ({{ now()->format('F/Y') }})
            </h2>
            <p style="color: #92400e; font-size: 11px; margin-top: 5px;">
                Total de {{ $emprestimosDoMes->count() }} empréstimo(s) registrado(s) este mês
            </p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 80px; background: #f59e0b;">Código</th>
                    <th style="background: #f59e0b;">Patrimônio</th>
                    <th style="width: 100px; background: #f59e0b;">De</th>
                    <th style="width: 100px; background: #f59e0b;">Para</th>
                    <th style="width: 80px; background: #f59e0b;">Data</th>
                    <th style="width: 60px; background: #f59e0b;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emprestimosDoMes as $emprestimo)
                    <tr>
                        <td><strong>{{ $emprestimo->patrimonio->codigo_barra }}</strong></td>
                        <td>{{ Str::limit($emprestimo->patrimonio->nome, 40) }}</td>
                        <td>{{ $emprestimo->localOriginal->nome }}</td>
                        <td>{{ $emprestimo->localEmprestado->nome }}</td>
                        <td>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</td>
                        <td>
                            @if($emprestimo->devolvido)
                                <span style="background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 8px; font-size: 9px;">
                                    Devolvido
                                </span>
                            @else
                                <span style="background: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 8px; font-size: 9px;">
                                    Ativo
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <p style="text-align: right; padding: 10px; font-weight: bold; color: #f59e0b;">
            Empréstimos ativos: {{ $emprestimosDoMes->where('devolvido', false)->count() }} | 
            Devolvidos: {{ $emprestimosDoMes->where('devolvido', true)->count() }}
        </p>
    </div>
    @endif
    
    <div class="footer">
        <p>© {{ date('Y') }} UNIVC - Sistema de Gestão de Patrimônios</p>
    </div>
</body>
</html>
