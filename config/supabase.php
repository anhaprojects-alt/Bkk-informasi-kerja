<?php

return [
    'url' => env('SUPABASE_URL', 'https://hfzsykrwfwjgoqxzwkmp.supabase.co'),
    'anon_key' => env('SUPABASE_ANON_KEY'),
    'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY'),

    'api' => [
        'url' => env('SUPABASE_URL') . '/rest/v1',
    ],

    'auth' => [
        'url' => env('SUPABASE_URL') . '/auth/v1',
    ],

    'storage' => [
        'url' => env('SUPABASE_URL') . '/storage/v1',
        'bucket' => env('SUPABASE_BUCKET', 'resumes'),
    ],

    'functions' => [
        'url' => env('SUPABASE_URL') . '/functions/v1',
    ],
];
