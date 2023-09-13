<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1694425988,
    'checksum' => '8e48550544a6e6068e0cbb2c153e75da',
    'files' => [
        'templates/cassava/custom/config/14' => [
            'assignments' => [
                'file' => 'templates/cassava/custom/config/14/assignments.yaml',
                'modified' => 1693562764
            ],
            'index' => [
                'file' => 'templates/cassava/custom/config/14/index.yaml',
                'modified' => 1694424954
            ],
            'layout' => [
                'file' => 'templates/cassava/custom/config/14/layout.yaml',
                'modified' => 1694424954
            ],
            'styles' => [
                'file' => 'templates/cassava/custom/config/14/styles.yaml',
                'modified' => 1693491164
            ]
        ]
    ],
    'data' => [
        'assignments' => [
            'menu' => [
                
            ],
            'style' => [
                
            ]
        ],
        'index' => [
            'name' => '14',
            'timestamp' => 1694424954,
            'version' => 7,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/default.png',
                'name' => 'default',
                'timestamp' => 1693302101
            ],
            'positions' => [
                'header' => 'Header',
                'breadcrumbs' => 'Breadcrumbs',
                'accordion' => 'Accordion',
                'slideshow' => 'Slideshow',
                'contacts' => 'Contacts',
                'Footer' => 'Footer'
            ],
            'sections' => [
                'header' => 'Header',
                'navigation' => 'Navigation',
                'main' => 'Main',
                'footer' => 'Footer',
                'offcanvas' => 'Offcanvas'
            ],
            'particles' => [
                'position' => [
                    'position-header' => 'Header',
                    'position-breadcrumbs' => 'Breadcrumbs',
                    'position-position-6586' => 'Accordion',
                    'position-position-2267' => 'Slideshow',
                    'position-position-4950' => 'Contacts',
                    'position-position-1184' => 'Footer'
                ],
                'logo' => [
                    'logo-1233' => 'Logo'
                ],
                'menu' => [
                    'menu-6698' => 'Menu'
                ],
                'messages' => [
                    'system-messages-1072' => 'System Messages'
                ],
                'content' => [
                    'system-content-9865' => 'Page Content'
                ],
                'mobile-menu' => [
                    'mobile-menu-3129' => 'Mobile-menu'
                ]
            ],
            'inherit' => [
                
            ]
        ],
        'layout' => [
            'version' => 2,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/default.png',
                'name' => 'default',
                'timestamp' => 1693302101
            ],
            'layout' => [
                '/header/' => [
                    0 => [
                        0 => 'position-header 60',
                        1 => 'logo-1233 40'
                    ]
                ],
                '/navigation/' => [
                    0 => [
                        0 => 'menu-6698'
                    ]
                ],
                '/main/' => [
                    0 => [
                        0 => 'position-breadcrumbs'
                    ],
                    1 => [
                        0 => 'system-messages-1072'
                    ],
                    2 => [
                        0 => 'position-position-6586'
                    ],
                    3 => [
                        0 => 'position-position-2267 70',
                        1 => 'position-position-4950 30'
                    ],
                    4 => [
                        0 => 'system-content-9865'
                    ]
                ],
                '/footer/' => [
                    0 => [
                        0 => 'position-position-1184'
                    ]
                ],
                'offcanvas' => [
                    0 => [
                        0 => 'mobile-menu-3129'
                    ]
                ]
            ],
            'structure' => [
                'header' => [
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'text-center',
                        'variations' => ''
                    ]
                ],
                'navigation' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => ''
                    ]
                ],
                'main' => [
                    'attributes' => [
                        'boxed' => ''
                    ]
                ],
                'footer' => [
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'sticky-footer',
                        'variations' => ''
                    ]
                ],
                'offcanvas' => [
                    'attributes' => [
                        'position' => 'g-offcanvas-right',
                        'class' => '',
                        'extra' => [
                            
                        ],
                        'swipe' => '1',
                        'css3animation' => '1'
                    ]
                ]
            ],
            'content' => [
                'position-header' => [
                    'attributes' => [
                        'key' => 'header'
                    ]
                ],
                'logo-1233' => [
                    'block' => [
                        'variations' => 'align-right',
                        'extra' => [
                            0 => [
                                'aria-label' => 'Header logo'
                            ]
                        ]
                    ]
                ],
                'position-breadcrumbs' => [
                    'attributes' => [
                        'key' => 'breadcrumbs'
                    ]
                ],
                'position-position-6586' => [
                    'title' => 'Accordion',
                    'attributes' => [
                        'key' => 'accordion'
                    ]
                ],
                'position-position-2267' => [
                    'title' => 'Slideshow',
                    'attributes' => [
                        'key' => 'slideshow'
                    ]
                ],
                'position-position-4950' => [
                    'title' => 'Contacts',
                    'attributes' => [
                        'key' => 'contacts'
                    ],
                    'block' => [
                        'id' => 'contacts-frontpage'
                    ]
                ],
                'position-position-1184' => [
                    'title' => 'Footer',
                    'attributes' => [
                        'key' => 'Footer'
                    ]
                ]
            ]
        ],
        'styles' => [
            'preset' => 'preset3'
        ]
    ]
];
