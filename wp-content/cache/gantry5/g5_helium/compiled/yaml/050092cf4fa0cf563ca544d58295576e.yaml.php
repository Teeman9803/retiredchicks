<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/Applications/MAMP/htdocs/retiredchicks/wp-content/themes/g5_helium/blueprints/content/single/meta-categories.yaml',
    'modified' => 1513089165,
    'data' => [
        'name' => 'Categories Meta',
        'description' => 'Options for displaying categories meta',
        'type' => 'single',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Display Categories',
                    'description' => 'Display categories that the post has been assigned to.',
                    'default' => 1
                ],
                'link' => [
                    'type' => 'input.checkbox',
                    'label' => 'Link Categories',
                    'description' => 'Link categories to their category page.',
                    'default' => 1
                ],
                'prefix' => [
                    'type' => 'input.text',
                    'label' => 'Categories Prefix',
                    'description' => 'Display text directly before the category name.',
                    'default' => 'Categories:'
                ]
            ]
        ]
    ]
];
