<?php

return [
    'guards' => [
        'api' => [
            'driver' => 'custom', // Menggunakan JWT untuk API guard
            'provider' => 'users', // Menyebutkan provider pengguna
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Pastikan ini model pengguna Anda
        ],
    ],
];
