<?php
return [

    "brands" => [
        "name" => __('brand::app.brands.brands'),
        "sort" => 4,
        "permissions" =>  [
            [
                'key' => 'brands.show',
                'name' => __('brand::app.brands.show'),
            ],
            [
                'key' => 'brands.create',
                'name' => __('brand::app.brands.create'),
            ],
            [
                'key' => 'brands.update',
                'name' => __('brand::app.brands.update'),
            ],
            [
                'key' => 'brands.destroy',
                'name' => __('brand::app.brands.destroy'),
            ],
        ]
    ],




];
