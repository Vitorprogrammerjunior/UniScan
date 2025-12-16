<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versão do Sistema
    |--------------------------------------------------------------------------
    |
    | Sempre que fizer uma atualização importante, incremente a versão
    | e adicione as mudanças no changelog. O pop-up aparecerá automaticamente
    | para todos os usuários uma única vez.
    |
    */

    'atual' => '1.1.0',

    'changelog' => [
        '1.1.0' => [
            'data' => '16/12/2024',
            'titulo' => '🎉 Novidades do UniScan!',
            'mudancas' => [
                '👥 Sistema multi-usuários - Agora vários usuários podem usar o sistema',
                '📐 QR Codes menores - Impressão mais compacta e discreta',
                '🔧 Correção na edição de patrimônios via QR Code',
                '📢 Pop-up de atualizações - Você será notificado sobre novidades',
            ],
        ],
        '1.0.0' => [
            'data' => '15/12/2024',
            'titulo' => '🚀 Lançamento do UniScan!',
            'mudancas' => [
                'Sistema de gestão de patrimônios com QR Code',
                'Cadastro de tipos e locais',
                'Geração de QR Codes em lote',
                'Relatórios em PDF',
                'Dashboard com estatísticas',
            ],
        ],
    ],
];
