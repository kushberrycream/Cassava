<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\MAMP\\htdocs\\cassava.nri.org/templates/cassava/blueprints/styles/showcase.yaml',
    'modified' => 1693302101,
    'data' => [
        'name' => 'Showcase Colors',
        'description' => 'Showcase colors for the Hydrogen theme',
        'type' => 'section',
        'form' => [
            'fields' => [
                'background' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Background',
                    'default' => '#354d59'
                ],
                'image' => [
                    'type' => 'input.imagepicker',
                    'label' => 'Image',
                    'default' => ''
                ],
                'text-color' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Text',
                    'default' => '#ffffff'
                ]
            ]
        ]
    ]
];
