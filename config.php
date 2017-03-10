<?php
return [
    'id' => 'dvelum_sitemap',
    'version' => '1.0',
    'author' => 'Kirill Yegorov',
    'name' => 'DVelum Sitemap',
    'configs' => './configs',
    'vendor'=>'Dvelum',
    'locales' => './locales',
    'autoloader'=> [
        './classes'
    ],
    'post-install'=>'Dvelum_Backend_Sitemap_Installer'
];