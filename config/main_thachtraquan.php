<?php

return [
    'currency_unit'         => '<sup>đ</sup>',
    'author_name'           => 'Thachtraquan',
    'founder_name'          => 'Thachtraquan',
    'founder_address'       => '165 Quang Trung, Rạch Giá',
    'founding'              => '2023-02-22',
    'company_name'          => 'Thachtraquan',
    'hotline'               => '0917.111.505',
    'email'                 => 'thachtraquan@gmail.com',
    'address'               => '165 Quang Trung, Rạch Giá',
    'company_description'   => 'Giới thiệu dịch vụ',
    'logo_750x460'          => 'public/images/upload/trang-diem-750.webp',
    'logo_main'             => 'images/upload/logo-hoaanhtuc-type-manager-upload.webp',
    'contacts'          => [
        [
            'type'      => 'customer service',
            'phone'     => '0917111505'
        ],
        [
            'type'      => 'technical support',
            'phone'     => '0917111505'
        ],
        [
            'type'      => 'sales',
            'phone'     => '0917111505'
        ]
    ],
    'products'          => [
        [
            'type'      => 'Product',
            'product'   => 'Thương mại điện tử'
        ]
    ],
    'socials'           => [
        'https://facebook.com/thachtraquan',
        'https://twitter.com/thachtraquan',
        'https://pinterest.com/thachtraquan',
        'https://youtube.com/thachtraquan'
    ],
    'storage'   => [
        'contentPage'       => 'public/contents/pages/',
        'contentBlog'       => 'public/contents/blogs/',
        'contentCategory'   => 'public/contents/categories/',
    ],
    'filter'    => [
        'price' => [
            [
                'name'  => 'Nhỏ hơn 100,000đ',
                'min'   => '0',
                'max'   => '100000'
            ],
            [
                'name'  => 'Từ 100,000đ - 200,000đ',
                'min'   => '100000',
                'max'   => '200000'
            ],
            [
                'name'  => 'Từ 200,000đ - 350,000đ',
                'min'   => '200000',
                'max'   => '350000'
            ],
            [
                'name'  => 'Từ 350,000đ - 500,000đ',
                'min'   => '350000',
                'max'   => '500000'
            ],
            [
                'name'  => 'Từ 500,000đ - 1,000,000đ',
                'min'   => '500000',
                'max'   => '1000000'
            ],
            [
                'name'  => 'Trên 1,000,000đ',
                'min'   => '1000000',
                'max'   => '9999999999999999999999'
            ]
        ]
    ],
    'cache'     => [
        'extension'     => 'html',
        'folderSave'    => 'public/caches/',
    ]
];