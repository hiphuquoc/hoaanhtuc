<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;
use App\Models\ThemeColor;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        /* tạo giao diện default - white */
        /* kiểm tra nếu có bản default - white rồi thì unactive các bản cũ */
        $themes     = Theme::select('*')
                        ->where('type', 'white')
                        ->get();
        foreach($themes as $theme) Theme::updateItem($theme->id, ['status' => 0]);
        /* insert theme_info */
        $idTheme    = Theme::insertItem([
            'name'      => 'Theme mặc định',
            'type'      => 'white',
            'status'    => 1
        ]);
        /* insert theme_color */
        $source     = [
            'colorLv1'          => '#144272',
            'colorLv2'          => '#205295',
            'colorSLv1'         => '#FF6E31',
            'colorSLv2'         => '#ff793f',
            'colorButtonLv1'    => '#FF6E31',
            'colorButtonLv2'    => '#ff793f',
            'colorTextLight'    => '#F7FF93',
            'colorText'         => '#243763',
            'colorLabel'        => '#AD8E70',
            'colorPrice'        => '#FF6E31',
            'colorStar'         => '#fcaf17',
            'colorSuccess'      => '#06d6a0',
            'colorRed'          => '#ed1c24'
        ];
        foreach($source as $key => $value){
            ThemeColor::insertItem([
                'theme_info_id' => $idTheme,
                'name'          => $key,
                'value'         => $value
            ]);
        }
    }
}
