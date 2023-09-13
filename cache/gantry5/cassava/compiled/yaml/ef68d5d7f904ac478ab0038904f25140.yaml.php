<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => 'C:\\MAMP\\htdocs\\cassava.nri.org/templates/cassava/blueprints/page.yaml',
    'modified' => 1694422670,
    'data' => [
        'name' => 'Page Settings',
        'description' => 'Settings that can be applied to the page.',
        'form' => [
            'fields' => [
                'doctype' => [
                    'type' => 'input.text',
                    'label' => 'Doctype',
                    'default' => 'html'
                ],
                'body.class' => [
                    'type' => 'input.text',
                    'label' => 'Body Class',
                    'default' => 'gantry'
                ]
            ]
        ]
    ]
];
