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
            'titulo' => 'Novidades do UniScan!',
            'mudancas' => [
                [
                    'icone' => 'fa-users',
                    'cor' => 'blue',
                    'texto' => 'Sistema Multi-usuários - Agora vários usuários podem gerenciar o sistema simultaneamente',
                ],
                [
                    'icone' => 'fa-bell',
                    'cor' => 'purple',
                    'texto' => 'Sistema de Atualizações - Você será notificado sempre que houver novidades no sistema',
                ],
                [
                    'icone' => 'fa-qrcode',
                    'cor' => 'green',
                    'texto' => 'QR Codes Compactos - Impressão menor e mais discreta para etiquetas',
                ],
                [
                    'icone' => 'fa-bug',
                    'cor' => 'red',
                    'texto' => 'Correções - Edição de patrimônios via QR Code funcionando perfeitamente',
                ],
            ],
        ],
        '1.0.0' => [
            'data' => '15/12/2024',
            'titulo' => 'Lançamento do UniScan!',
            'mudancas' => [
                [
                    'icone' => 'fa-rocket',
                    'cor' => 'green',
                    'texto' => 'Sistema de gestão de patrimônios com QR Code',
                ],
                [
                    'icone' => 'fa-tags',
                    'cor' => 'blue',
                    'texto' => 'Cadastro de tipos e locais de armazenamento',
                ],
                [
                    'icone' => 'fa-print',
                    'cor' => 'purple',
                    'texto' => 'Geração de QR Codes em lote para impressão',
                ],
                [
                    'icone' => 'fa-file-pdf',
                    'cor' => 'red',
                    'texto' => 'Relatórios em PDF com filtros avançados',
                ],
            ],
        ],
    ],
];
