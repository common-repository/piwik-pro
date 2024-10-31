# Clearcode WordPress Settings

[WordPress](https://wordpress.org) Settings library by [Clearcode](https://clearcode.cc). 

# Installation

```console
$ composer require clearcode/wordpress-settings
```

```php
require __DIR__ . '/vendor/autoload.php';

new Settings( [
    'option_name' => [
        'group' => 'option_group', // optional
        'type' => 'string', // optional
        'description' => 'setting description', // optional
        'rest' => false, // optional
        'pages' => [
            'page_slug' => [
                'title' => 'page title',
                'capability' => 'manage_options', // optional
                'menu' => [
                    'title' => 'menu title',
                    'icon' => 'dashicons-admin-plugins',
                    'position' => null,
                    'parent' => 'options-general.php'
                ],
                'tabs' => [
                    'tab_1' => [
                        'title' => 'tab title',
                        'sections' => [
                            'section_1' => [
                                'title' => 'section title',
                                'render' => [
                                    'template' => 'section', // template file path
                                    'args' => [ 
                                        'content' => 'section description'
                                    ]
                                ],
                                'fields' => [
                                    'field_1' => [
                                        'title' => 'field title',
                                        'default' => 'default value',
                                        'sanitize' => function( $value ) { return $value; }, // callback function
                                        'render' => [
                                            'template' => 'input', // supported templates: input, textarea, select
                                            'args' => [
                                                'atts' => [
                                                    'type' => 'text'
                                                ],
                                                'before' => 'before text',
                                                'after' => 'after text',
                                                'description' => 'description text'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
] );
```

# License

GPL3.0+ see [LICENSE.txt](LICENSE.txt) and [AUTHORS.txt](AUTHORS.txt)