<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:/MAMP/htdocs/cassava.nri.org/media/gantry5/engines/nucleus/admin/blueprints/layout/inheritance/offcanvas.yaml',
    'modified' => 1693301407,
    'data' => [
        'name' => 'Inheritance',
        'description' => 'Offcanvas inheritance tab',
        'type' => 'offcanvas.inheritance',
        'form' => [
            'fields' => [
                'mode' => [
                    'type' => 'input.radios',
                    'label' => 'Mode',
                    'description' => 'Whether to clone or inherit the particle properties. <code>inherit</code> makes the Offcanvas identical to that of the inherited outline.',
                    'default' => 'inherit',
                    'options' => [
                        'clone' => 'Clone',
                        'inherit' => 'Inherit'
                    ]
                ],
                'outline' => [
                    'type' => 'gantry.outlines',
                    'label' => 'Outline',
                    'description' => 'Outline to inherit from.',
                    'selectize' => [
                        'allowEmptyOption' => true
                    ],
                    'options' => [
                        '' => 'No Inheritance'
                    ]
                ],
                'include' => [
                    'type' => 'input.multicheckbox',
                    'label' => 'Replace',
                    'description' => 'Which parts of the Offcanvas to inherit?',
                    'options' => [
                        'attributes' => 'Offcanvas Attributes',
                        'block' => 'Block Attributes',
                        'children' => 'Particles within Offcanvas'
                    ]
                ]
            ]
        ]
    ]
];
