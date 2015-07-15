<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'       => "orbiagro.com.ve", // set false to total remove
            'description' => 'Compra y venta de productos agro-industriales', // set false to total remove
            'separator'   => ' - ',
            'keywords'    => ['alimentos', 'agro-industria', 'subastas', 'ventas'],
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null
        ]
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'orbiagro.com.ve', // set false to total remove
            'description' => 'Compra y venta de productos agro-industriales', // set false to total remove
            'url'         => false,
            'type'        => false,
            'site_name'   => 'orbiagro.com.ve',
            'images'      => [],
        ]
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ]
    ]
];
