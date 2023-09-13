<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1693823853,
    'checksum' => '6b4095fe95827574936b2151cb776ca9',
    'files' => [
        'templates/cassava/custom/config/_offline' => [
            'index' => [
                'file' => 'templates/cassava/custom/config/_offline/index.yaml',
                'modified' => 1693316148
            ],
            'layout' => [
                'file' => 'templates/cassava/custom/config/_offline/layout.yaml',
                'modified' => 1693316148
            ]
        ],
        'templates/cassava/custom/config/default' => [
            'index' => [
                'file' => 'templates/cassava/custom/config/default/index.yaml',
                'modified' => 1693390578
            ],
            'layout' => [
                'file' => 'templates/cassava/custom/config/default/layout.yaml',
                'modified' => 1693390578
            ],
            'page/assets' => [
                'file' => 'templates/cassava/custom/config/default/page/assets.yaml',
                'modified' => 1693491423
            ],
            'page/body' => [
                'file' => 'templates/cassava/custom/config/default/page/body.yaml',
                'modified' => 1693491423
            ],
            'page/fontawesome' => [
                'file' => 'templates/cassava/custom/config/default/page/fontawesome.yaml',
                'modified' => 1693491423
            ],
            'page/head' => [
                'file' => 'templates/cassava/custom/config/default/page/head.yaml',
                'modified' => 1693491423
            ],
            'particles/branding' => [
                'file' => 'templates/cassava/custom/config/default/particles/branding.yaml',
                'modified' => 1693571176
            ],
            'particles/content' => [
                'file' => 'templates/cassava/custom/config/default/particles/content.yaml',
                'modified' => 1693571176
            ],
            'particles/contentarray' => [
                'file' => 'templates/cassava/custom/config/default/particles/contentarray.yaml',
                'modified' => 1693571176
            ],
            'particles/copyright' => [
                'file' => 'templates/cassava/custom/config/default/particles/copyright.yaml',
                'modified' => 1693571176
            ],
            'particles/custom' => [
                'file' => 'templates/cassava/custom/config/default/particles/custom.yaml',
                'modified' => 1693571176
            ],
            'particles/date' => [
                'file' => 'templates/cassava/custom/config/default/particles/date.yaml',
                'modified' => 1693571176
            ],
            'particles/logo' => [
                'file' => 'templates/cassava/custom/config/default/particles/logo.yaml',
                'modified' => 1693571176
            ],
            'particles/menu' => [
                'file' => 'templates/cassava/custom/config/default/particles/menu.yaml',
                'modified' => 1693571176
            ],
            'particles/messages' => [
                'file' => 'templates/cassava/custom/config/default/particles/messages.yaml',
                'modified' => 1693571176
            ],
            'particles/mobile-menu' => [
                'file' => 'templates/cassava/custom/config/default/particles/mobile-menu.yaml',
                'modified' => 1693571176
            ],
            'particles/module' => [
                'file' => 'templates/cassava/custom/config/default/particles/module.yaml',
                'modified' => 1693571176
            ],
            'particles/position' => [
                'file' => 'templates/cassava/custom/config/default/particles/position.yaml',
                'modified' => 1693571176
            ],
            'particles/sample' => [
                'file' => 'templates/cassava/custom/config/default/particles/sample.yaml',
                'modified' => 1693571176
            ],
            'particles/social' => [
                'file' => 'templates/cassava/custom/config/default/particles/social.yaml',
                'modified' => 1693571176
            ],
            'particles/spacer' => [
                'file' => 'templates/cassava/custom/config/default/particles/spacer.yaml',
                'modified' => 1693571176
            ],
            'particles/totop' => [
                'file' => 'templates/cassava/custom/config/default/particles/totop.yaml',
                'modified' => 1693571176
            ],
            'styles' => [
                'file' => 'templates/cassava/custom/config/default/styles.yaml',
                'modified' => 1693823851
            ]
        ],
        'templates/cassava/config/default' => [
            'particles/logo' => [
                'file' => 'templates/cassava/config/default/particles/logo.yaml',
                'modified' => 1693394530
            ]
        ]
    ],
    'data' => [
        'particles' => [
            'sample' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1'
            ],
            'branding' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '0',
                'content' => 'Powered by <a href="http://www.gantry.org/" title="Gantry Framework" class="g-powered-by">Gantry Framework</a>',
                'css' => [
                    'class' => 'branding'
                ]
            ],
            'copyright' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'date' => [
                    'start' => 'now',
                    'end' => 'now'
                ],
                'owner' => 'Natural Resources Institute, University of Greenwich'
            ],
            'custom' => [
                'caching' => [
                    'type' => 'config_matches',
                    'values' => [
                        'twig' => '0',
                        'filter' => '0'
                    ]
                ],
                'enabled' => '1',
                'twig' => '0',
                'filter' => '0'
            ],
            'logo' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'target' => '_blank',
                'link' => '1',
                'url' => 'https://www.nri.org',
                'image' => 'gantry-media://images/logos/NRI-Logo_smwhite.png',
                'text' => '',
                'class' => '',
                'height' => '10rem',
                'svg' => ''
            ],
            'menu' => [
                'caching' => [
                    'type' => 'menu'
                ],
                'enabled' => '1',
                'menu' => '',
                'base' => '/',
                'startLevel' => '1',
                'maxLevels' => '0',
                'renderTitles' => '0',
                'hoverExpand' => '1',
                'mobileTarget' => '0',
                'forceTarget' => '0'
            ],
            'mobile-menu' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1'
            ],
            'social' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'css' => [
                    'class' => 'social'
                ],
                'target' => '_blank',
                'display' => 'icons_only',
                'title' => '',
                'items' => [
                    0 => [
                        'name' => 'Facebook'
                    ]
                ]
            ],
            'spacer' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1'
            ],
            'totop' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'css' => [
                    'class' => 'totop'
                ],
                'icon' => '',
                'content' => '',
                'title' => ''
            ],
            'analytics' => [
                'enabled' => true,
                'ua' => [
                    'anonym' => false
                ]
            ],
            'assets' => [
                'enabled' => true
            ],
            'content' => [
                'enabled' => '1'
            ],
            'contentarray' => [
                'enabled' => '1',
                'article' => [
                    'filter' => [
                        'featured' => ''
                    ],
                    'limit' => [
                        'total' => 2,
                        'columns' => 2,
                        'start' => 0
                    ],
                    'display' => [
                        'pagination_buttons' => '',
                        'image' => [
                            'enabled' => 'intro'
                        ],
                        'text' => [
                            'type' => 'intro',
                            'limit' => '',
                            'formatting' => 'text',
                            'prepare' => '0'
                        ],
                        'edit' => '0',
                        'title' => [
                            'enabled' => 'show',
                            'limit' => ''
                        ],
                        'date' => [
                            'enabled' => 'published',
                            'format' => 'l, F d, Y'
                        ],
                        'read_more' => [
                            'enabled' => 'show',
                            'label' => '',
                            'css' => ''
                        ],
                        'author' => [
                            'enabled' => 'show'
                        ],
                        'category' => [
                            'enabled' => 'link'
                        ],
                        'hits' => [
                            'enabled' => 'show'
                        ]
                    ],
                    'sort' => [
                        'orderby' => 'publish_up',
                        'ordering' => 'ASC'
                    ]
                ],
                'css' => [
                    'class' => ''
                ],
                'extra' => [
                    
                ]
            ],
            'date' => [
                'enabled' => '1',
                'css' => [
                    'class' => 'date'
                ],
                'date' => [
                    'formats' => 'l, F d, Y'
                ]
            ],
            'frameworks' => [
                'enabled' => true,
                'jquery' => [
                    'enabled' => 0,
                    'ui_core' => 0,
                    'ui_sortable' => 0
                ],
                'bootstrap' => [
                    'enabled' => 0
                ],
                'mootools' => [
                    'enabled' => 0,
                    'more' => 0
                ]
            ],
            'lightcase' => [
                'enabled' => true
            ],
            'messages' => [
                'enabled' => '1'
            ],
            'module' => [
                'enabled' => '1',
                'chrome' => ''
            ],
            'position' => [
                'enabled' => '1',
                'chrome' => ''
            ]
        ],
        'page' => [
            'doctype' => 'html',
            'body' => [
                'class' => 'gantry',
                'attribs' => [
                    'class' => 'gantry',
                    'id' => '',
                    'extra' => [
                        
                    ]
                ],
                'layout' => [
                    'sections' => '0'
                ],
                'body_top' => '',
                'body_bottom' => ''
            ],
            'fontawesome' => [
                'enable' => '1',
                'version' => 'fa4',
                'fa4_compatibility' => '1',
                'content_compatibility' => '1',
                'html_css_import' => '',
                'html_js_import' => ''
            ],
            'assets' => [
                'favicon' => '',
                'touchicon' => '',
                'css' => [
                    
                ],
                'javascript' => [
                    
                ]
            ],
            'head' => [
                'meta' => [
                    
                ],
                'head_bottom' => '',
                'atoms' => [
                    
                ]
            ]
        ],
        'styles' => [
            'accent' => [
                'color-1' => '#558b2f',
                'color-2' => '#8bc34a'
            ],
            'base' => [
                'background' => '#ffffff',
                'text-color' => '#666666',
                'body-font' => 'roboto, sans-serif',
                'heading-font' => 'roboto, sans-serif'
            ],
            'breakpoints' => [
                'large-desktop-container' => '75rem',
                'desktop-container' => '60rem',
                'tablet-container' => '48rem',
                'large-mobile-container' => '30rem',
                'mobile-menu-breakpoint' => '48rem'
            ],
            'feature' => [
                'background' => '#ffffff',
                'text-color' => '#666666'
            ],
            'footer' => [
                'background' => '#ffffff',
                'text-color' => '#666666'
            ],
            'header' => [
                'background' => '#3c7216',
                'text-color' => '#ffffff'
            ],
            'main' => [
                'background' => '#ffffff',
                'text-color' => '#666666'
            ],
            'menu' => [
                'col-width' => '17rem',
                'animation' => 'g-fade',
                'hide-on-mobile' => '0'
            ],
            'navigation' => [
                'background' => '#558b2f',
                'text-color' => '#ffffff',
                'overlay' => 'rgba(0, 0, 0, 0.4)'
            ],
            'offcanvas' => [
                'background' => '#344e2c',
                'text-color' => '#ffffff',
                'width' => '17rem',
                'toggle-color' => '#ffffff',
                'toggle-visibility' => '1'
            ],
            'showcase' => [
                'background' => '#344e2c',
                'image' => '',
                'text-color' => '#ffffff'
            ],
            'subfeature' => [
                'background' => '#f0f0f0',
                'text-color' => '#666666'
            ],
            'preset' => 'preset3'
        ],
        'index' => [
            'name' => '_offline',
            'timestamp' => 1693316148,
            'version' => 7,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/offline.png',
                'name' => '_offline',
                'timestamp' => 1693302101
            ],
            'positions' => [
                'footer' => 'Footer'
            ],
            'sections' => [
                'header' => 'Header',
                'main' => 'Main',
                'footer' => 'Footer'
            ],
            'particles' => [
                'logo' => [
                    'logo-5619' => 'Logo'
                ],
                'spacer' => [
                    'spacer-7077' => 'Spacer'
                ],
                'messages' => [
                    'system-messages-2188' => 'System Messages'
                ],
                'content' => [
                    'system-content-1355' => 'Page Content'
                ],
                'position' => [
                    'position-footer' => 'Footer'
                ],
                'copyright' => [
                    'copyright-5245' => 'Copyright'
                ]
            ],
            'inherit' => [
                
            ]
        ],
        'layout' => [
            'version' => 2,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/offline.png',
                'name' => '_offline',
                'timestamp' => 1693302101
            ],
            'layout' => [
                '/header/' => [
                    0 => [
                        0 => 'logo-5619 30',
                        1 => 'spacer-7077 70'
                    ]
                ],
                '/main/' => [
                    0 => [
                        0 => 'system-messages-2188'
                    ],
                    1 => [
                        0 => 'system-content-1355'
                    ]
                ],
                '/footer/' => [
                    0 => [
                        0 => 'position-footer'
                    ],
                    1 => [
                        0 => 'copyright-5245'
                    ]
                ]
            ],
            'structure' => [
                'header' => [
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
                        'boxed' => ''
                    ]
                ]
            ],
            'content' => [
                'position-footer' => [
                    'attributes' => [
                        'key' => 'footer'
                    ]
                ]
            ]
        ]
    ]
];
