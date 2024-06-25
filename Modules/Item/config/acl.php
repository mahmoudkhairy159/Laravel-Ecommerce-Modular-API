<?php
return [

    "items" => [
        "name" => __('item::app.items.items'),
        "sort" => 10,
        "permissions" =>  [
            [
                'key' => 'items.show',
                'name' => __('item::app.items.show'),
            ],
            [
                'key' => 'items.create',
                'name' => __('item::app.items.create'),
            ],
            [
                'key' => 'items.update',
                'name' => __('item::app.items.update'),
            ],
            [
                'key' => 'items.destroy',
                'name' => __('item::app.items.destroy'),
            ],
        ]
        ],
        "itemImages" => [
        "name" => __('item::app.itemImages.itemImages'),
        "sort" => 11,
        "permissions" =>  [
            [
                'key' => 'itemImages.show',
                'name' => __('item::app.itemImages.show'),
            ],
            [
                'key' => 'itemImages.create',
                'name' => __('item::app.itemImages.create'),
            ],
            [
                'key' => 'itemImages.update',
                'name' => __('item::app.itemImages.update'),
            ],
            [
                'key' => 'itemImages.destroy',
                'name' => __('item::app.itemImages.destroy'),
            ],
        ]
        ],
        "relatedItems" => [
        "name" => __('item::app.relatedItems.relatedItems'),
        "sort" => 10,
        "permissions" =>  [
            [
                'key' => 'relatedItems.show',
                'name' => __('item::app.relatedItems.show'),
            ],
            [
                'key' => 'relatedItems.create',
                'name' => __('item::app.relatedItems.create'),
            ],
            [
                'key' => 'relatedItems.update',
                'name' => __('item::app.relatedItems.update'),
            ],
            [
                'key' => 'relatedItems.destroy',
                'name' => __('item::app.relatedItems.destroy'),
            ],
        ]
        ],


];
