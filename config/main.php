<?php

return [
    'currency_unit'         => '<sup>đ</sup>',
    'author_name'           => 'Hoaanhtuc',
    'founder_name'          => 'Hoaanhtuc',
    'founder_address'       => 'Ấp Hòa An B, xã Ngọc Hòa, Giồng Riềng',
    'founding'              => '2023-01-30',
    'company_name'          => 'Hoaanhtuc',
    'hotline'               => '0819.443.755',
    'email'                 => 'hoaanhtucshop@gmail.com',
    'address'               => 'Ấp Hòa An B, xã Ngọc Hòa, Giồng Riềng',
    'company_description'   => 'Giới thiệu dịch vụ',
    'logo_750x460'          => 'public/images/upload/trang-diem-750.webp',
    'logo_main'             => 'images/upload/logo-hoaanhtuc-type-manager-upload.webp',
    'contacts'          => [
        [
            'type'      => 'customer service',
            'phone'     => '0819443755'
        ],
        [
            'type'      => 'technical support',
            'phone'     => '0968617168'
        ],
        [
            'type'      => 'sales',
            'phone'     => '0819443755'
        ]
    ],
    'products'          => [
        [
            'type'      => 'Product',
            'product'   => 'Thương mại điện tử'
        ]
    ],
    'socials'           => [
        'https://facebook.com/hoaanhtuc',
        'https://twitter.com/hoaanhtuc',
        'https://pinterest.com/hoaanhtuc',
        'https://youtube.com/hoaanhtuc'
    ],
    'storage'   => [
        'contentPage'   => 'public/contents/pages/',
        'contentBlog'   => 'public/contents/blogs/',
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