<?php
return [

    "userPayments" => [
        "name" => __('payment::app.userPayments.userPayments'),
        "sort" => 9,
        "permissions" =>  [
            [
                'key' => 'userPayments.show',
                'name' => __('payment::app.userPayments.show'),
            ],
            [
                'key' => 'userPayments.create',
                'name' => __('payment::app.userPayments.create'),
            ],
            [
                'key' => 'userPayments.update',
                'name' => __('payment::app.userPayments.update'),
            ],
            [
                'key' => 'userPayments.destroy',
                'name' => __('payment::app.userPayments.destroy'),
            ],
        ]
    ]


];
