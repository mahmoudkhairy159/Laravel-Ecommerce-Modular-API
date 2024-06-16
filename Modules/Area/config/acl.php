<?php
return [
    "countries" => [
        "name" => __('area::app.countries.countries'),
        "sort" => 3,
        "permissions" =>  [
            [
                'key' => 'countries.show',
                'name' => __('area::app.countries.show'),
            ],
            [
                'key' => 'countries.create',
                'name' => __('area::app.countries.create'),
            ],
            [
                'key' => 'countries.update',
                'name' => __('area::app.countries.update'),
            ],
            [
                'key' => 'countries.destroy',
                'name' => __('area::app.countries.destroy'),
            ],
        ]
    ],
    "cities" => [
        "name" => __('area::app.cities.cities'),
        "sort" => 4,
        "permissions" =>  [
            [
                'key' => 'cities.show',
                'name' => __('area::app.cities.show'),
            ],
            [
                'key' => 'cities.create',
                'name' => __('area::app.cities.create'),
            ],
            [
                'key' => 'cities.update',
                'name' => __('area::app.cities.update'),
            ],
            [
                'key' => 'cities.destroy',
                'name' => __('area::app.cities.destroy'),
            ],
        ]
    ]


];
