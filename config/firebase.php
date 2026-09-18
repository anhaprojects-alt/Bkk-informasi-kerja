<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Project Credentials Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure your Firebase project credentials and keys
    | to be used throughout the BKK application for Phone Auth & Messaging.
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID', 'data01-c6d26'),
    'server_key' => env('FIREBASE_SERVER_KEY', ''),
    'api_key' => env('FIREBASE_API_KEY', ''),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN', ''),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', ''),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID', ''),
    'app_id' => env('FIREBASE_APP_ID', ''),
    'measurement_id' => env('FIREBASE_MEASUREMENT_ID', ''),

    // Path to the Firebase service account JSON file for server-side SDK admin operations
    'credentials_path' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase_credentials.json')),
];
