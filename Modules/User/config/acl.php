<?php
return [
    "users" => [
        "name" => __('user::app.users.users'),
        "sort" => 5,
        "permissions" =>  [
            [
                'key' => 'users.show',
                'name' => __('user::app.users.show'),
            ],
            [
                'key' => 'users.create',
                'name' => __('user::app.users.create'),
            ],
            [
                'key' => 'users.update',
                'name' => __('user::app.users.update'),
            ],
            [
                'key' => 'users.destroy',
                'name' => __('user::app.users.destroy'),
            ],
        ]
    ],
    "userProfiles" => [
        "name" => __('user::app.userProfiles.userProfiles'),
        "sort" => 6,
        "permissions" =>  [
            [
                'key' => 'userProfiles.show',
                'name' => __('user::app.userProfiles.show'),
            ],
            [
                'key' => 'userProfiles.create',
                'name' => __('user::app.userProfiles.create'),
            ],
            [
                'key' => 'userProfiles.update',
                'name' => __('user::app.userProfiles.update'),
            ],
            [
                'key' => 'userProfiles.destroy',
                'name' => __('user::app.userProfiles.destroy'),
            ],
        ]
    ]


];
