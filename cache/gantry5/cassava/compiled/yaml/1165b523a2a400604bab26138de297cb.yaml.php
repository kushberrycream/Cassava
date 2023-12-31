<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'gantry-admin://blueprints/layout/offcanvas.yaml',
    'modified' => 1693301407,
    'data' => [
        'name' => 'Offcanvas',
        'description' => 'Section outside the viewport.',
        'type' => 'offcanvas',
        'form' => [
            'fields' => [
                'position' => [
                    'type' => 'select.selectize',
                    'label' => 'Position',
                    'description' => 'Enter position where you would like see the section.',
                    'default' => 'g-offcanvas-left',
                    'options' => [
                        'g-offcanvas-left' => 'Left',
                        'g-offcanvas-right' => 'Right'
                    ]
                ],
                'class' => [
                    'type' => 'input.selectize',
                    'label' => 'CSS Classes',
                    'description' => 'Enter CSS class names.',
                    'default' => NULL
                ],
                'extra' => [
                    'type' => 'collection.keyvalue',
                    'label' => 'Tag Attributes',
                    'description' => 'Extra Tag attributes.',
                    'key_placeholder' => 'Key (data-*, style, ...)',
                    'value_placeholder' => 'Value',
                    'exclude' => [
                        0 => 'id',
                        1 => 'class'
                    ]
                ],
                'swipe' => [
                    'type' => 'input.checkbox',
                    'label' => 'Swipe Gesture',
                    'description' => 'Enables or disables the Swipe gestures for opening and closing the offcanvas.',
                    'default' => 1
                ],
                'css3animation' => [
                    'type' => 'input.checkbox',
                    'label' => 'CSS3 Animation',
                    'description' => 'Animates the offcanvas using translate3d. If causes issues due to fixed elements, disable to fallback to left animation',
                    'default' => 1
                ],
                '_inherit' => [
                    'type' => 'gantry.inherit'
                ]
            ]
        ]
    ]
];
