<?php

return [
    /*
     * The dashboard supports these themes:
     *
     * - light: always use light mode
     * - dark: always use dark mode
     * - device: follow the OS preference for determining light or dark mode
     * - auto: use light mode when the sun is up, dark mode when the sun is down
     */
    'theme' => 'dark',

    /*
     * When the dashboard uses the `auto` theme, these coordinates will be used
     * to determine whether the sun is up or down.
     */
    'auto_theme_location' => [
        'lat' => 52.7017668,
        'lng' => -2.0181104,
    ],

    /*
     * These scripts will be loaded when the dashboard is displayed.
     */
    'scripts' => [
        'alpinejs' => 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
    ],

    /*
     * These stylesheets will be loaded when the dashboard is displayed.
     */
    'stylesheets' => [
        'inter' => 'https://rsms.me/inter/inter.css',
        'tailwind' => 'https://unpkg.com/tailwindcss@0.3.0/dist/tailwind.min.css'
    ],

    'tiles' => [
        'time_weather' => [
            'open_weather_map_key' => env('OPEN_WEATHER_MAP_KEY'),
            'open_weather_map_city' => 'Cannock',
            'units' => 'metric', // 'metric' or 'imperial' (metric is default)
        ],
        'calendar' => [
            'ids' => [
                env('GOOGLE_CALENDAR_ID'),
            ],
            'refresh_interval_in_seconds' => 60,
        ],
        'cryptowatch' => [
            'refresh_interval_in_seconds' => 60,
        ]
    ],
];
