<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\MAMP\\htdocs\\cassava.nri.org/templates/g5_hydrogen/blueprints/styles/feature.yaml',
    'modified' => 1693302009,
    'data' => [
        'name' => 'Feature Colors',
        'description' => 'Feature colors for the Hydrogen theme',
        'type' => 'section',
        'form' => [
            'fields' => [
                'background' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Background',
                    'default' => '#ffffff'
                ],
                'text-color' => [
                    'type' => 'input.colorpicker',
                    'label' => 'Text',
                    'default' => '#666666'
                ]
            ]
        ]
    ]
];
