<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Jobs\BuildScss;
use App\Models\Theme;
use App\Models\ThemeColor;

class ThemeController extends Controller {

    public function view(Request $request){
        $message            = $request->get('message') ?? null;
        $id                 = $request->get('id') ?? 0;
        $item               = Theme::select('*')
                                ->where('id', $id)
                                ->with('colors')
                                ->first();
        $item->colors       = self::convertCollectionColors($item->colors);
        /* type */
        $type               = !empty($item) ? 'edit' : 'create';
        $type               = $request->get('type') ?? $type;
        return view('admin.theme.view', compact('item', 'type', 'message'));
    }
    
    public function list(Request $request){
        $themes     = Theme::select('*')
                        ->with('colors')
                        ->get();
        for($i=0;$i<$themes->count();++$i){
            $themes[$i]->colors = self::convertCollectionColors($themes[$i]->colors);
        }
        return view('admin.theme.list', compact('themes'));
    }

    public function create(Request $request){
        try {
            DB::beginTransaction();
            /* insert theme_info */
            $idTheme = Theme::insertItem([
                'name'      => $request->get('name'),
                'type'      => $request->get('type'),
                'status'    => 0
            ]);
            /* insert theme_color */
            foreach($request->colors as $key => $value){
                ThemeColor::insertItem([
                    'theme_info_id' => $idTheme,
                    'name'          => $key,
                    'value'         => $value
                ]);
            }
            /* áp dụng màu */
            self::setColor($idTheme);
            DB::commit();
            /* Message */
            $message        = [
                'type'      => 'success',
                'message'   => '<strong>Thành công!</strong> Đã thêm mới Theme!'
            ];
        } catch (\Exception $exception){
            DB::rollBack();
            /* Message */
            $message        = [
                'type'      => 'danger',
                'message'   => '<strong>Thất bại!</strong> Có lỗi xảy ra, vui lòng thử lại'
            ];
        }
        $request->session()->put('message', $message);
        return redirect()->route('admin.theme.view', ['id' => $idTheme]);
    }

    public function update(Request $request){
        try {
            DB::beginTransaction();
            $idTheme            = $request->get('theme_info_id');
            /* update theme_info */
            Theme::updateItem($idTheme, [
                'name'  => $request->get('name'),
                'type'  => $request->get('type')
            ]);
            /* update theme_color */
            ThemeColor::select('*')
                ->where('theme_info_id', $idTheme)
                ->delete();
            foreach($request->colors as $key => $value){
                ThemeColor::insertItem([
                    'theme_info_id' => $idTheme,
                    'name'          => $key,
                    'value'         => $value
                ]);
            }
            /* áp dụng màu */
            self::setColor($idTheme);
            DB::commit();
            /* Message */
            $message        = [
                'type'      => 'success',
                'message'   => '<strong>Thành công!</strong> Đã cập nhật Theme!'
            ];
        } catch (\Exception $exception){
            DB::rollBack();
            /* Message */
            $message        = [
                'type'      => 'danger',
                'message'   => '<strong>Thất bại!</strong> Có lỗi xảy ra, vui lòng thử lại'
            ];
        }
        $request->session()->put('message', $message);
        return redirect()->route('admin.theme.view', ['id' => $idTheme]);
    }

    public static function setColor($id = null){
        /* trường hợp chỉ định 1 id theme */
        if(!empty($id)){
            $infoTheme      = Theme::select('*')
                                ->where('id', $id)
                                ->first();
            $typeTheme      = $infoTheme->type;
            /* chuyển tất cả các theme cùng loại khác sang non-active */
            $themes         = Theme::select('*')
                            ->where('type', $typeTheme)
                            ->get();
            foreach($themes as $theme){
                Theme::updateItem($theme->id, ['status' => 0]);
            }
            /* active theme được chỉ định */
            Theme::updateItem($id, ['status' => 1]);
        }else { /* trường hợp không chỉ định */
            /* lấy thông tin theme đang được active */
            $infoTheme      = Theme::select('*')
                                ->where('type', 'white')
                                ->where('status', 1)
                                ->with('colors')
                                ->first();
        }
        /* tiến hành set color */
        if(!empty($infoTheme->colors)&&$infoTheme->colors->isNotEmpty()){
            /* tạo nội dung file color.scss */
            $content    = null;
            foreach($infoTheme->colors as $color){
                if(!empty($color->name)&&!empty($color->value)){
                    $content .= '$'.$color->name.':'.$color->value.';';
                }
            }
            /* ghi vào file color.scss */
            file_put_contents('../resources/sources/main/color.scss', $content);
            /* chạy command */
            BuildScss::dispatch()->onConnection('database');
        }
        return redirect()->route('admin.theme.list');
    }

    private static function convertCollectionColors($collectionColor = null){
        $output     = new \Illuminate\Database\Eloquent\Collection;
        if(!empty($collectionColor)){
            foreach($collectionColor as $color){
                $output->{$color->name} = $color->value;
            }
        }
        return $output;
    }
}
