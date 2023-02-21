<?php 

return [
    'default'               => '/storage/images/image-default-750x460.png',
    'default_square'        => '/storage/images/image-default-660x660.png',
    'folder_upload'         => 'public/images/upload/',
    'extension'             => 'webp',
    'quality'               => '90',
    'resize_normal_width'   => 750,
    'resize_normal_height'  => 460,
    'resize_small_width'    => 400,
    'resize_small_height'   => 245,
    'resize_mini_width'     => 100,
    'resize_mini_height'    => 60,
    /* danh sách action: copy_url, change_name, change_image, delete */
    'keyType'               => '-type-',
    'type'                  => [
        'default'               => ['copy_url', 'change_image'],
        'manager-upload'        => ['copy_url', 'change_name', 'change_image', 'delete']
    ],
    'loading_main_css'          => '/storage/images/svg/loading_plane_bge9ecef.svg',
    'loading_main_gif'          => 'public/images/loading-gif-1-min.gif',
    'loading_main_gif_small'    => 'public/images/loading-gif-1-200.gif'
];