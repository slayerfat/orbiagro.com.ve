<?php

$title = 'orbiagro.com.ve - compra y venta de productos agro-industriales';
$desc = 'Compra y venta de productos agro-industriales en Venezuela';

return [
    'meta'      => [
        'defaults'       => [
            'title'       => $title,
            'description' => $desc,
            'separator'   => ' - ',
            'keywords'    => ['alimentos', 'agro-industria', 'subastas', 'ventas', 'articulos', 'productos'],
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
            'title'       => $title,
            'description' => $desc,
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
