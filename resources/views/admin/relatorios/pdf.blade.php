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
    
    <div class="footer">
        <p>© {{ date('Y') }} UNIVC - Sistema de Gestão de Patrimônios</p>
    </div>
</body>
</html>
