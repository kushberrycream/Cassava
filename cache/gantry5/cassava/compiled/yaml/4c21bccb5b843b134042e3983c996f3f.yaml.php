<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/MAMP/htdocs/cassava.nri.org/templates/cassava/layouts/3_column_-_left.yaml',
    'modified' => 1693302101,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/3-col-left.png'
        ],
        'layout' => [
            '/header/' => [
                0 => [
                    0 => 'logo 30',
                    1 => 'position-header 70'
                ]
            ],
            '/navigation/' => [
                0 => 'menu'
            ],
            '/container-main/' => [
                0 => [
                    0 => [
                        'sidebar 20' => [
                            0 => 'position-sidebar'
                        ]
                    ],
                    1 => [
                        'aside 20' => [
                            0 => 'position-aside'
                        ]
                    ],
                    2 => [
                        'main 60' => [
                            0 => 'position-breadcrumbs',
                            1 => 'system-messages',
                            2 => 'system-content'
                        ]
                    ]
                ]
            ],
            '/footer/' => [
                0 => 'position-footer',
                1 => [
                    0 => 'copyright 40',
                    1 => 'spacer 30',
                    2 => 'branding 30'
                ]
            ],
            'offcanvas' => [
                0 => 'mobile-menu'
            ]
        ],
        'structure' => [
            'sidebar' => [
                'subtype' => 'aside',
                'block' => [
                    'fixed' => 1
                ]
            ],
            'aside' => [
                'block' => [
                    'fixed' => 1
                ]
            ]
        ]
    ]
];
