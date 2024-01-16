<?php
/**
 * This file provides to overwrite the default HumHub / Yii configuration by your local common (Console and Web) environments
 * @see http://www.yiiframework.com/doc-2.0/guide-concept-configurations.html
 * @see http://docs.humhub.org/admin-installation-configuration.html
 * @see http://docs.humhub.org/dev-environment.html
 */
return [
    'components' => [
        'mailer' => [
        'transport' => [
                'host' => 'smtp.gmail.com',
                'port' => 25,
                'username' => 'garfayinc@gmail.com',
                'password' => 'gnyykmfzytzzzqhf',
                'scheme' => 'smtp',
            ]
        ]
    ]
];
