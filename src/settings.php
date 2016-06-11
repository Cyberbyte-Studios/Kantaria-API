<?php
/**
 * @SWG\Info(title="Kantaria Api", version="0.1")
 */

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        
        'jwtSecret' => getenv('JWT_SECRET')
    ],
];
