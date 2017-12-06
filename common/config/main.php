<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'defaultRoute' => 'app/index',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '127721136634-50j9v23b26f2e078bncqdr7qvm7csl51.apps.googleusercontent.com',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => 'vk_client_id',
                    'clientSecret' => 'vk_client_secret',

                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'clientId' => 'twitter_client_id',
                    'clientSecret' => 'twitter_client_secret',

                ],
            ],
        ]
    ],
];
