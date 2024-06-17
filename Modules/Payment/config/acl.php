<?php
return [

    "userPayments" => [
        "name" => __('user::app.userPayments.userPayments'),
        "sort" => 9,
        "permissions" =>  [
            [
                'key' => 'userPayments.show',
                'name' => __('user::app.userPayments.show'),
            ],
            [
                'key' => 'userPayments.create',
                'name' => __('user::app.userPayments.create'),
            ],
            [
                'key' => 'userPayments.update',
                'name' => __('user::app.userPayments.update'),
            ],
            [
                'key' => 'userPayments.destroy',
                'name' => __('user::app.userPayments.destroy'),
            ],
        ]
    ]


];
