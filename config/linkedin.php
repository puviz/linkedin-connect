<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Puviz LinkedIn Access Client
    |--------------------------------------------------------------------------
    |
    | If you enable client hashing, you should set the personal access client
    | ID and unhashed secret within your environment file. The values will
    | get used while issuing fresh personal access tokens to your users.
    |
    */

    'linkedin_access_client' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/linkedin-connector/callback',
    ],

    /*
    |--------------------------------------------------------------------------
    | Puviz LinkedIn Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration value allows you to customize the storage options
    | for Passport, such as the database connection that should be used
    | by Passport's internal database models which store tokens, etc.
    |
    */

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ],

    /*
  |--------------------------------------------------------------------------
  | Puviz LinkedIn Router
  |--------------------------------------------------------------------------
  |
  | This configuration value allows you to customize the router
  | prefix and middleware.
  |
  */
    'route' =>[
        'prefix' => 'linkedin-connector',
        'middleware' => ['web', 'auth'],
    ]
];
