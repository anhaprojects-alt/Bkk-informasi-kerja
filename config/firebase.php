<?php

return [
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'api_key' => env('FIREBASE_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
    'app_id' => env('FIREBASE_APP_ID'),
    'measurement_id' => env('FIREBASE_MEASUREMENT_ID'),
    'server_key' => env('FIREBASE_SERVER_KEY'),
    'credentials_path' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase_credentials.json')),
    'credentials_json' => env('FIREBASE_CREDENTIALS_JSON'),
];
