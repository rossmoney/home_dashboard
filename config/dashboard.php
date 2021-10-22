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
            'btcgbp_4h' => [
                'exchange' => 'kraken',
                'currency_pair' => 'btcgbp',
                'time_period' => '4h',
                'title' => 'CryptoWatch Kraken BTC-GBP 4 Hours'
            ],
            'btcgbp_1d' => [
                'exchange' => 'kraken',
                'currency_pair' => 'btcgbp',
                'time_period' => '1d',
                'title' => 'CryptoWatch Kraken BTC-GBP 1 Day'
            ],
            'refresh_interval_in_seconds' => 60,
        ],
        "train_times" => [
            'hnf_to_bhm' => [ 
                'origin_station' => 'Hednesford',
                'destination_station' => 'Birmingham New Street',
                'data' => 'departures',
                'title' => 'Train Departures Hednesford > Birmingham NS'
            ],
            'refresh_interval_in_seconds' => 60,
        ]
    ],
];
