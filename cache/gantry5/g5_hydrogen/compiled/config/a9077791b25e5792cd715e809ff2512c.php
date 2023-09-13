<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1693311420,
    'checksum' => '8ceac7cdc006694a796965ced36aa581',
    'files' => [
        'templates/g5_hydrogen/custom/config/13' => [
            'index' => [
                'file' => 'templates/g5_hydrogen/custom/config/13/index.yaml',
                'modified' => 1693302010
            ],
            'layout' => [
                'file' => 'templates/g5_hydrogen/custom/config/13/layout.yaml',
                'modified' => 1693302010
            ]
        ],
        'templates/g5_hydrogen/custom/config/default' => [
            'index' => [
                'file' => 'templates/g5_hydrogen/custom/config/default/index.yaml',
                'modified' => 1693302010
            ],
            'layout' => [
                'file' => 'templates/g5_hydrogen/custom/config/default/layout.yaml',
                'modified' => 1693302010
            ]
        ],
        'templates/g5_hydrogen/config/default' => [
            'particles/logo' => [
                'file' => 'templates/g5_hydrogen/config/default/particles/logo.yaml',
                'modified' => 1693302009
            ]
        ]
    ],
    'data' => [
        'particles' => [
            'sample' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'branding' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'content' => 'Powered by <a href="http://www.gantry.org/" title="Gantry Framework" class="g-powered-by">Gantry Framework</a>',
                'css' => [
                    'class' => 'branding'
                ]
            ],
            'copyright' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'date' => [
                    'start' => 'now',
                    'end' => 'now'
                ]
            ],
            'custom' => [
                'caching' => [
                    'type' => 'config_matches',
                    'values' => [
                        'twig' => '0',
                        'filter' => '0'
                    ]
                ],
                'enabled' => true,
                'twig' => '0',
                'filter' => '0'
            ],
            'logo' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'target' => '_self',
                'link' => true,
                'url' => '',
                'image' => 'gantry-assets://images/gantry5-logo.png',
                'text' => 'Gantry 5',
                'class' => 'gantry-logo'
            ],
            'menu' => [
                'caching' => [
                    'type' => 'menu'
                ],
                'enabled' => true,
                'menu' => '',
                'base' => '/',
                'startLevel' => 1,
                'maxLevels' => 0,
                'renderTitles' => 0,
                'hoverExpand' => 1,
                'mobileTarget' => 0,
                'forceTarget' => 0
            ],
            'mobile-menu' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'social' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'css' => [
                    'class' => 'social'
                ],
                'target' => '',
                'display' => 'both'
            ],
            'spacer' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'totop' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'css' => [
                    'class' => 'totop'
                ]
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
                'enabled' => true
            ],
            'contentarray' => [
                'enabled' => true,
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
                            'prepare' => false
                        ],
                        'edit' => false,
                        'title' => [
                            'enabled' => 'show'
                        ],
                        'date' => [
                            'enabled' => 'published',
                            'format' => 'l, F d, Y'
                        ],
                        'read_more' => [
                            'enabled' => 'show'
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
                ]
            ],
            'date' => [
                'enabled' => true,
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
                'enabled' => true
            ],
            'module' => [
                'enabled' => true
            ],
            'position' => [
                'enabled' => true
            ]
        ],
        'page' => [
            'doctype' => 'html',
            'body' => [
                'class' => 'gantry',
                'attribs' => [
                    'class' => 'gantry'
                ],
                'layout' => [
                    'sections' => 0
                ]
            ],
            'fontawesome' => [
                'enable' => 1,
                'version' => 'fa4',
                'fa4_compatibility' => 1,
                'content_compatibility' => 1
            ]
        ],
        'styles' => [
            'accent' => [
                'color-1' => '#439a86',
                'color-2' => '#8f4dae'
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
                'background' => '#2a816d',
                'text-color' => '#ffffff'
            ],
            'main' => [
                'background' => '#ffffff',
                'text-color' => '#666666'
            ],
            'menu' => [
                'col-width' => '180px',
                'animation' => 'g-fade',
                'hide-on-mobile' => 0
            ],
            'navigation' => [
                'background' => '#439a86',
                'text-color' => '#ffffff',
                'overlay' => 'rgba(0, 0, 0, 0.4)'
            ],
            'offcanvas' => [
                'background' => '#354d59',
                'text-color' => '#ffffff',
                'width' => '17rem',
                'toggle-color' => '#ffffff',
                'toggle-visibility' => 1
            ],
            'showcase' => [
                'background' => '#354d59',
                'image' => '',
                'text-color' => '#ffffff'
            ],
            'subfeature' => [
                'background' => '#f0f0f0',
                'text-color' => '#666666'
            ]
        ],
        'index' => [
            'name' => 13,
            'timestamp' => 1693302010,
            'version' => 7,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/home.png',
                'name' => 'home',
                'timestamp' => 1693302010
            ],
            'positions' => [
                'footer' => 'Footer'
            ],
            'sections' => [
                'header' => 'Header',
                'navigation' => 'Navigation',
                'showcase' => 'Showcase',
                'feature' => 'Feature',
                'subfeature' => 'Subfeature',
                'main' => 'Main',
                'footer' => 'Footer',
                'offcanvas' => 'Offcanvas'
            ],
            'particles' => [
                'menu' => [
                    'menu-5203' => 'Menu'
                ],
                'sample' => [
                    'sample-1' => 'Gantry 5',
                    'sample-2' => 'Getting Started',
                    'sample-3' => 'Key Features'
                ],
                'messages' => [
                    'system-messages-8428' => 'System Messages'
                ],
                'position' => [
                    'position-footer' => 'Footer'
                ],
                'copyright' => [
                    'copyright-6243' => 'Copyright'
                ],
                'social' => [
                    'social-6139' => 'Social'
                ],
                'branding' => [
                    'branding-5386' => 'Branding'
                ],
                'mobile-menu' => [
                    'mobile-menu-9929' => 'Mobile Menu'
                ]
            ],
            'inherit' => [
                
            ]
        ],
        'layout' => [
            'version' => 2,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/home.png',
                'name' => 'home',
                'timestamp' => 1693302010
            ],
            'layout' => [
                '/header/' => [
                    
                ],
                '/navigation/' => [
                    0 => [
                        0 => 'menu-5203'
                    ]
                ],
                '/showcase/' => [
                    0 => [
                        0 => 'sample-1'
                    ]
                ],
                '/feature/' => [
                    
                ],
                '/main/' => [
                    0 => [
                        0 => 'system-messages-8428'
                    ],
                    1 => [
                        0 => 'sample-2'
                    ]
                ],
                '/subfeature/' => [
                    0 => [
                        0 => 'sample-3'
                    ]
                ],
                '/footer/' => [
                    0 => [
                        0 => 'position-footer'
                    ],
                    1 => [
                        0 => 'copyright-6243 33.3',
                        1 => 'social-6139 33.3',
                        2 => 'branding-5386 33.3'
                    ]
                ],
                'offcanvas' => [
                    0 => [
                        0 => 'mobile-menu-9929'
                    ]
                ]
            ],
            'structure' => [
                'header' => [
                    'attributes' => [
                        'boxed' => ''
                    ]
                ],
                'navigation' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => ''
                    ]
                ],
                'showcase' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => ''
                    ]
                ],
                'feature' => [
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
                'subfeature' => [
                    'attributes' => [
                        'class' => 'flush',
                        'boxed' => ''
                    ],
                    'type' => 'section'
                ],
                'footer' => [
                    'attributes' => [
                        'boxed' => ''
                    ]
                ]
            ],
            'content' => [
                'sample-1' => [
                    'title' => 'Gantry 5',
                    'attributes' => [
                        'image' => 'gantry-assets://images/gantry5-logo.png',
                        'headline' => '',
                        'description' => '<p>Gantry 5 is the most customizable and powerful version of the framework yet. Packed full of features such as <a href="http://docs.gantry.org/gantry5/configure/layout-manager">drag-and-drop layout creation</a> and the powerful particle system, Gantry 5 has been designed from the ground up to be lightning fast and hassle free.</p>',
                        'link' => 'http://docs.gantry.org',
                        'linktext' => 'Read More'
                    ]
                ],
                'sample-2' => [
                    'title' => 'Getting Started',
                    'attributes' => [
                        'description' => '<h1 class="center">Getting Started</h1>
<div class="device-promo"><div class="macbook"><div class="macbook-color"></div></div><div class="ipad"><div class="ipad-color"></div></div><div class="iphone"><div class="iphone-color"></div></div></div><p>Welcome to Gantry 5 featuring <strong>Hydrogen</strong>, the first theme built on the Gantry 5 framework. If you want to get started, the best way is to navigate to the Gantry Administrator via your platform\'s Administration panel.</p>

<p>Once you are in the Gantry 5 Administrator, you will be able to edit virtually every aspect of your site from its <strong>Layout</strong> to its <strong>Style</strong>. You can even refine how the menus appear using Gantry 5’s new <strong>Menu Editor</strong>.</p>

<p>You can set different style preferences for different pages, and have them assigned accordingly using the <strong>Assignments</strong> administrative panel.</p>

<div class="info-box"><div class="fa fa-graduation-cap float-left"></div><p>Look for more information on Gantry 5 in our documentation, and stay tuned to the RocketTheme Blog for more information on new features and development updates as development continues.</p>

<p><a href="http://docs.gantry.org" class="button">Learn More</a></p></div>

<h1 class="center">How to Contribute</h1>

<div class="g-grid">
<div class="g-block size-37"><p>Thank you for using Gantry 5 and the Hydrogen theme. We welcome you to contribute to the project by submitting bug reports through <strong>GitHub</strong>, and/or submit your own code changes to the <strong>Gantry 5 project</strong> for consideration.</p>
<p><a href="https://github.com/gantry/gantry5" class="button">Gantry 5 on GitHub</a></p>
</div>
<div class="g-block size-26 middle"><div class="fa fa-github-square"></div></div>

<div class="g-block size-37"><p>If you would like to assist in creating documentation for Gantry 5, you can do so through the <strong>Gantry 5 Documentation</strong> project on <strong>GitHub</strong>.</p>
<p><a href="https://github.com/gantry/docs" class="button">Gantry Docs on GitHub</a></p>
</div>
</div>

<p>Once again, thank you for participating. We hope you enjoy testing Gantry 5 every bit as much as we have enjoyed creating it.</p>'
                    ]
                ],
                'sample-3' => [
                    'title' => 'Key Features',
                    'attributes' => [
                        'headline' => 'Key Features',
                        'description' => '<p>Gantry 5 is packed full of features created to empower the development of designs into fully functional layouts with the absolute minimum effort and fuss</p>',
                        'samples' => [
                            0 => [
                                'icon' => 'fa fa-code',
                                'subtitle' => '',
                                'description' => '<p>Gantry 5 leverages the power of <a href="https://twig.symfony.com/doc/1.x/">Twig</a> to make creating powerful, dynamic themes quick and easy.</p>',
                                'title' => 'Twig Templating'
                            ],
                            1 => [
                                'icon' => 'far fa-newspaper',
                                'subtitle' => '',
                                'description' => '<p>Drag-and-drop functionality gives you the power to place content blocks, resize them, and configure their unique settings in seconds.</p>',
                                'title' => 'Layout Manager'
                            ],
                            2 => [
                                'icon' => 'fa fa-cubes',
                                'subtitle' => '',
                                'description' => '<p>Create, configure, and manage content blocks as well as special features and functionality with the powerful particle system.</p>',
                                'title' => 'Particles System'
                            ]
                        ]
                    ]
                ],
                'position-footer' => [
                    'attributes' => [
                        'key' => 'footer'
                    ]
                ],
                'social-6139' => [
                    'attributes' => [
                        'css' => [
                            'class' => 'social-items'
                        ],
                        'items' => [
                            0 => [
                                'icon' => 'fa fa-twitter',
                                'text' => 'Twitter',
                                'link' => 'http://twitter.com/rockettheme',
                                'name' => 'Twitter'
                            ],
                            1 => [
                                'icon' => 'fa fa-facebook',
                                'text' => 'Facebook',
                                'link' => 'http://facebook.com/rockettheme',
                                'name' => 'Facebook'
                            ],
                            2 => [
                                'icon' => 'fa fa-google',
                                'text' => 'Google',
                                'link' => 'http://plus.google.com/+rockettheme',
                                'name' => 'Google'
                            ],
                            3 => [
                                'icon' => 'fa fa-rss',
                                'text' => 'RSS',
                                'link' => 'http://www.rockettheme.com/product-updates?rss',
                                'name' => 'RSS'
                            ]
                        ]
                    ],
                    'block' => [
                        'variations' => 'center'
                    ]
                ],
                'branding-5386' => [
                    'block' => [
                        'variations' => 'align-right'
                    ]
                ],
                'mobile-menu-9929' => [
                    'title' => 'Mobile Menu'
                ]
            ]
        ]
    ]
];
