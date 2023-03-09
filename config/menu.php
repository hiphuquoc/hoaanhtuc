<?php
return [
    'left-menu-admin'   => [
        [
            'name'      => 'Quản lí đơn',
            'route'     => 'admin.order.list',
            'icon'      => '<i class="fa-regular fa-file-lines"></i>'
        ],
        [
            'name'      => 'Sản phẩm',
            'route'     => '',
            'icon'      => '<i class="fa-solid fa-box-open"></i>',
            'child'     => [
                [
                    'name'  => '1. Danh sách',
                    'route' => 'admin.product.list',
                    'icon'  => '<i data-feather=\'circle\'></i>',
                    // 'child' => [
                    //     [
                    //         'name'  => '1.1. Điểm đến',
                    //         'route' => '',
                    //         'icon'  => '<i data-feather=\'circle\'></i>'
                    //     ]
                    // ]
                ],
                [
                    'name'  => '2. Danh mục',
                    'route' => 'admin.category.list',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ],
                [
                    'name'  => '3. Nhãn hàng',
                    'route' => 'admin.brand.list',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ]
            ]
        ],
        [
            'name'      => 'Quản lí trang',
            'route'     => 'admin.page.list',
            'icon'      => '<i class="fa-regular fa-file-lines"></i>',
            // 'child'     => [
            //     [
            //         'name'  => '1. Danh sách',
            //         'route' => '',
            //         'icon'  => '<i data-feather=\'circle\'></i>'
            //     ]
            // ]
        ],
        [
            'name'      => 'Quản lí Blog',
            'route'     => '',
            'icon'      => '<i class="fa-solid fa-blog"></i>',
            'child'     => [
                [
                    'name'  => '1. Tin tức',
                    'route' => 'admin.blog.list',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ],
                [
                    'name'  => '1. Chuyên mục',
                    'route' => 'admin.categoryBlog.list',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ]
            ]
        ],
        [
            'name'      => 'Quản lí ảnh',
            'route'     => 'admin.image.list',
            'icon'      => '<i class="fa-regular fa-images"></i>',
            // 'child'     => [
            //     [
            //         'name'  => '1. Danh sách',
            //         'route' => 'admin.category.list',
            //         'icon'  => '<i data-feather=\'circle\'></i>'
            //     ]
            // ]
        ],
        [
            'name'      => 'Cài đặt',
            'route'     => '',
            'icon'      => '<i class="fa-solid fa-gear"></i>',
            'child'     => [
                [
                    'name'  => '1. Giao diện',
                    'route' => 'admin.theme.list',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ],
                [
                    'name'  => '2. Slider home',
                    'route' => 'admin.setting.slider',
                    'icon'  => '<i data-feather=\'circle\'></i>'
                ]
            ]
        ],
        [
            'name'      => 'Xóa cache',
            'route'     => 'admin.cache.clearCache',
            'icon'      => '<i class="fa-sharp fa-solid fa-xmark"></i>'
        ],
    ]
];