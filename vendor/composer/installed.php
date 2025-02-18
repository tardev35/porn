<?php return array(
    'root' => array(
        'name' => 'wp-script/famoustube',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '049f8e568d1a608ed85ce67ab356246cd49df3d2',
        'type' => 'wordpress-theme',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => false,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v1.12.0',
            'version' => '1.12.0.0',
            'reference' => 'd20a64ed3c94748397ff5973488761b22f6d3f19',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roundcube/plugin-installer' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'wp-script/famoustube' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '049f8e568d1a608ed85ce67ab356246cd49df3d2',
            'type' => 'wordpress-theme',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
