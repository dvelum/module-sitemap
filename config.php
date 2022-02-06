<?php
return [
    'id' => 'dvelum-module-sitemap',
    'version' => '3.0.0',
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