<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/MAMP/htdocs/cassava.nri.org/templates/cassava/layouts/_joomla_-_protostar.yaml',
    'modified' => 1693302101,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/3-col.png'
        ],
        'layout' => [
            '/header/' => [
                0 => [
                    0 => 'logo 50',
                    1 => 'position-0 50'
                ]
            ],
            '/navigation/' => [
                0 => 'menu'
            ],
            '/container-main/' => [
                0 => [
                    0 => [
                        'sidebar 20' => [
                            0 => 'position-8'
                        ]
                    ],
                    1 => [
                        'main 60' => [
                            0 => 'position-3',
                            1 => 'system-messages',
                            2 => 'system-content',
                            3 => 'position-2'
                        ]
                    ],
                    2 => [
                        'aside 20' => [
                            0 => 'position-7'
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
