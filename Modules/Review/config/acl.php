<?php
return [


        "reviews" => [
            "name" => __('review::app.reviews.reviews'),
            "sort" => 13,
            "permissions" =>  [
                [
                    'key' => 'reviews.show',
                    'name' => __('review::app.reviews.show'),
                ],
                [
                    'key' => 'reviews.create',
                    'name' => __('review::app.reviews.create'),
                ],
                [
                    'key' => 'reviews.update',
                    'name' => __('review::app.reviews.update'),
                ],
                [
                    'key' => 'reviews.destroy',
                    'name' => __('review::app.reviews.destroy'),
                ],
            ]
        ]


];
