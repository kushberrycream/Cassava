<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/MAMP/htdocs/cassava.nri.org/templates/cassava/layouts/_joomla_-_beez3.yaml',
    'modified' => 1693302101,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/3-col.png'
        ],
        'layout' => [
            '/header/' => [
                0 => [
                    0 => 'logo',
                    1 => 'position-0'
                ]
            ],
            '/navigation/' => [
                0 => 'menu'
            ],
            '/container-main/' => [
                0 => [
                    0 => [
                        'sidebar 20' => [
                            0 => 'position-7',
                            1 => 'position-4',
                            2 => 'position-5'
                        ]
                    ],
                    1 => [
                        'main 60' => [
                            0 => 'position-2',
                            1 => 'position-12',
                            2 => 'system-messages',
                            3 => 'system-content'
                        ]
                    ],
                    2 => [
                        'aside 20' => [
                            0 => 'position-6',
                            1 => 'position-8',
                            2 => 'position-3'
                        ]
                    ]
                ]
            ],
            '/footer/' => [
                0 => [
                    0 => 'position-9',
                    1 => 'position-10',
                    2 => 'position-11'
                ],
                1 => 'position-14'
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
        ],
        'content' => [
            'position-0' => [
                'attributes' => [
                    'chrome' => 'none'
                ]
            ]
        ]
    ]
];
