<?php
return [
    'id' => 'dvelum-module-sitemap',
    'version' => '1.0.5',
    'author' => 'Kirill Yegorov',
    'name' => 'DVelum Sitemap',
    'configs' => './configs',
    'vendor'=>'Dvelum',
    'locales' => './locales',
    'autoloader'=> [
        './classes'
    ],
    'post-install'=>'\\Dvelum\\Sitemap\\Installer'
];