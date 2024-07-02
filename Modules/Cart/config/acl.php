<?php
return [
    "carts" => [
        "name" => __('cart::app.carts.carts'),
        "sort" => 19,
        "permissions" =>  [
            [
                'key' => 'carts.show',
                'name' => __('cart::app.carts.show'),
            ],
            [
                'key' => 'carts.create',
                'name' => __('cart::app.carts.create'),
            ],
            [
                'key' => 'carts.update',
                'name' => __('cart::app.carts.update'),
            ],
            [
                'key' => 'carts.destroy',
                'name' => __('cart::app.carts.destroy'),
            ],
        ]
    ],



];
