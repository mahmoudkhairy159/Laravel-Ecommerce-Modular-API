<?php
return [

    "orders" => [
        "name" => __('order::app.orders.orders'),
        "sort" => 14,
        "permissions" =>  [
            [
                'key' => 'orders.show',
                'name' => __('order::app.orders.show'),
            ],
            [
                'key' => 'orders.create',
                'name' => __('order::app.orders.create'),
            ],
            [
                'key' => 'orders.update',
                'name' => __('order::app.orders.update'),
            ],
            [
                'key' => 'orders.destroy',
                'name' => __('order::app.orders.destroy'),
            ],
        ]
        ],
        "orderHistories" => [
        "name" => __('order::app.orderHistories.orderHistories'),
        "sort" => 15,
        "permissions" =>  [
            [
                'key' => 'orderHistories.show',
                'name' => __('order::app.orderHistories.show'),
            ],
            [
                'key' => 'orderHistories.create',
                'name' => __('order::app.orderHistories.create'),
            ],
            [
                'key' => 'orderHistories.update',
                'name' => __('order::app.orderHistories.update'),
            ],
            [
                'key' => 'orderHistories.destroy',
                'name' => __('order::app.orderHistories.destroy'),
            ],
        ]
        ],
        "orderShippingInformation" => [
        "name" => __('order::app.orderShippingInformation.orderShippingInformation'),
        "sort" => 16,
        "permissions" =>  [
            [
                'key' => 'orderShippingInformation.show',
                'name' => __('order::app.orderShippingInformation.show'),
            ],
            [
                'key' => 'orderShippingInformation.create',
                'name' => __('order::app.orderShippingInformation.create'),
            ],
            [
                'key' => 'orderShippingInformation.update',
                'name' => __('order::app.orderShippingInformation.update'),
            ],
            [
                'key' => 'orderShippingInformation.destroy',
                'name' => __('order::app.orderShippingInformation.destroy'),
            ],
        ]
        ],
        "OrderItems" => [
        "name" => __('order::app.OrderItems.OrderItems'),
        "sort" => 17,
        "permissions" =>  [
            [
                'key' => 'OrderItems.show',
                'name' => __('order::app.OrderItems.show'),
            ],
            [
                'key' => 'OrderItems.create',
                'name' => __('order::app.OrderItems.create'),
            ],
            [
                'key' => 'OrderItems.update',
                'name' => __('order::app.OrderItems.update'),
            ],
            [
                'key' => 'OrderItems.destroy',
                'name' => __('order::app.OrderItems.destroy'),
            ],
        ]
        ],


];
