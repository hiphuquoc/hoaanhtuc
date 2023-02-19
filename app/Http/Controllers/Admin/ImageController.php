<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemFile;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;

use App\Services\BuildInsertUpdateModel;

class ImageController extends Controller {

    public function __construct(BuildInsertUpdateModel $BuildInsertUpdateModel){
        $this->BuildInsertUpdateModel  = $BuildInsertUpdateModel;
    }

    public function list(Request $request){
        $params['search_name']  = $request->get('search_name') ?? null;
        $list                   = null;
        if(!empty($params['search_name'])){
            $list               = glob(Storage::path(config('image.folder_upload')).'*'.$params['search_name'].'*');
        }
        return view('admin.image.list', compact('list', 'params'));
    }

    public function loadImage(Request $request){
        if(!empty($request->get('image_name'))){
            $tmp                = glob(Storage::path(config('image.folder_upload').$request->get('image_name').'*'));
            $item               = $tmp[0];
            return view('admin.image.oneRow', compact('item'));
        }
    }

    public function loadModal(Request $request){
        $result             = [];
        if(!empty($request->get('type'))&&!empty($request->get('basename'))){
            $image          = Storage::url(config('image.folder_upload')).$request->get('basename');
            if($request->get('type')==='changeName'){
                $head       = 'Sửa tên ảnh';
                $body       = view('admin.image.formModalChangeName', compact('image'))->render();
                $action     = route('admin.image.changeName');
            }else if($request->get('type')=='changeImage'){
                $head       = 'Thay đổi ảnh';
                $body       = view('admin.image.formModalChangeImage', compact('image'))->render();
                $action     = route('admin.image.changeImage');
            }
        }
        $result['head']     = $head;
        $result['body']     = $body;
        $result['action']   = $action;
        return json_encode($result);
    }

    public function removeImage(Request $request){
        $flag               = false;
        if(!empty($request->get('basename_image'))){
            $imagePath      = Storage::path(config('image.folder_upload')).$request->get('basename_image');
            /* remove folder */
            if(file_exists($imagePath)) {
                if(unlink($imagePath)) $flag = true;
            }
            /* remove database */
            $imageUrl       = config('image.folder_upload').$request->get('basename_image');
            SystemFile::select('*')
                    ->where('file_path', $imageUrl)
                    ->delete();
        }
        return $flag;
    }

    public function changeName(Request $request){
        if(!empty($request->get('basename_old'))&&!empty($request->get('name_new'))){
            $filenameOld    = $request->get('basename_old');
            $tmp            = explode(config('image.keyType'), pathinfo($filenameOld)['filename']);
            $typeImageOld   = null;
            if(key_exists(end($tmp), config('image.type'))) $typeImageOld = config('image.keyType').end($tmp);
            /* thông tin image cũ */
            $imageOld       = Storage::path(config('image.folder_upload').$filenameOld);
            $infoImageOld   = pathinfo($imageOld);
            $extension      = $infoImageOld['extension'];
            /* thông tin image mới */
            $filenameNew    = $request->get('name_new').$typeImageOld.'.'.$extension;
            $arrayFlag      = $this->checkImageExists($filenameOld, $filenameNew);
            /* rename */
            if($arrayFlag['flag']==true){
                /* thay trong folder */
                rename(Storage::path(config('image.folder_upload').$filenameOld), Storage::path(config('image.folder_upload').$filenameNew));
                /* trả kết quả */
                $result['flag']     = true;
                $result['message']  = 'Thay tên ảnh thành công!';
                return json_encode($result);
            }else {
                return json_encode($arrayFlag);
            }
            /* không thay trong database vì tính năng này hiện chỉ dùng cho các ảnh upload bằng manager image */
        }
        $result['flag']             = false;
        $result['message']          = 'Tên ảnh cũ /mới không được để trống!';
        return json_encode($result);
    }

    public function changeImage(Request $request){
        $flag                       = false;
        $message                    = '';
        if(!empty($request->get('basename_image'))&&!empty($request->file('image_new'))){
            /* thông tin ảnh cũ */
            $imagePathOld           = Storage::path(config('image.folder_upload').$request->get('basename_image'));
            $fileSaved              = self::uploadImage($request->file('image_new'), $imagePathOld);
            if(!empty($fileSaved)) $flag = true;
        }
        $result['flag']             = $flag;
        $result['message']          = $message;
        return json_encode($result);
    }

    public function checkImageExists($basenameOld, $basenameNew){
        $result                     = [];
        if(!empty($basenameOld)&&!empty($basenameNew)){
            /* kiểm tra trường hợp cả 2 trùng nhau */
            if($basenameOld==$basenameNew) {
                $result['flag']     = false;
                $result['message']  = 'Tên ảnh mới trùng với Tên ảnh cũ!';
                return $result;
            }
            /* kiểm tra trường hợp trùng trong thư mục */
            if(file_exists(public_path($basenameNew))){
                $result['flag']     = false;
                $result['message']  = 'Ảnh mới trùng với một ảnh khác trong thư mục!';
                return $result;
            }
            /* kiểm tra trường hợp trùng trong database */
            $tmp                    = SystemFile::select('*')
                                        ->where('file_name', $basenameNew)
                                        ->first();
            if(!empty($tmp)){
                $result['flag']     = false;
                $result['message']  = 'Ảnh mới trùng với một ảnh khác trong CSDL!';
                return $result;
            }
            /* hợp lệ */
            $result['flag']         = true;
            $result['message']      = null;
        }
        return $result;
    }

    public function uploadImages(Request $request){
        $count                  = 0;
        $content                = '';
        if(!empty($request->file('image_upload'))){
            foreach($request->file('image_upload') as $image){
                $imageName      = $image->getClientOriginalName();
                $imageFileName  = \App\Helpers\Charactor::convertStrToUrl(pathinfo($imageName)['filename']);
                $extension      = config('image.extension');
                $filePathUpload = Storage::path(config('image.folder_upload').$imageFileName.'.'.$extension);
                $fileSaved      = self::uploadImage($image, $filePathUpload, 'copy', '-type-manager-upload');
                $content        .= view('admin.image.oneRow', [
                    'item'  => $fileSaved,
                    'style' => 'box-shadow: 0 0 5px rgb(0, 123, 255)'
                ]);
                ++$count;
            }
        }
        $result['count']    = $count;
        $result['content']  = $content;
        return json_encode($result);
    }

    public static function uploadImage($requestImage, $filePathUpload, $action = 'rewrite', $addType = null){
        $fileSaved          = null;
        if(!empty($requestImage)){
            /* thêm type cho filePath */
            $imageFileName  = pathinfo($filePathUpload)['filename'];
            $extension      = config('image.extension');
            $fileNameUpload = $imageFileName.$addType.'.'.$extension;
            $filePathUpload = Storage::path(config('image.folder_upload').$fileNameUpload);
            /* trường hợp copy */
            if($action=='copy') {
                if(file_exists($filePathUpload)){
                    $fileNameUpload = $imageFileName.'-'.time().$addType.'.'.$extension;
                    $filePathUpload = Storage::path(config('image.folder_upload').$fileNameUpload);
                }
            }
            /* thêm ảnh */    
            ImageManagerStatic::make($requestImage->getRealPath())
                ->save($filePathUpload);
            $fileSaved      = $filePathUpload;
        }
        return $fileSaved;
    }

    // public static function toolRename(){
    //     ini_set('max_execution_time', '0');
    //     $data           = glob(Storage::path('public/images/backup/'.'*'));
    //     foreach($data as $image){
    //         $tmp        = pathinfo($image);
    //         $newName    = $tmp['dirname'].'/'.$tmp['filename'].'-type-manager-upload'.'.'.$tmp['extension'];
    //         rename($image, $newName);
    //     }
    // }

    public static function replaceImageInContentWithLoading($content){
        if(!empty($content)){
            preg_match_all('#(<img.*>)#imsU', $content, $match);
            $dataAtrrImage  = $match[1];
            $dataImage      = [];
            $i              = 0;
            foreach($dataAtrrImage as $attrImage){
                $dataImage[$i]['source']   = $attrImage;
                /* src */
                preg_match('#src="(.*)"#imsU', $attrImage, $match);
                $dataImage[$i]['src']      = $match[1];
                /* data-src */
                preg_match('#data-src="(.*)"#imsU', $attrImage, $match);
                $dataImage[$i]['data-src'] = $match[1] ?? null;
                /* alt và title */
                preg_match('#alt="(.*)"#imsU', $attrImage, $match);
                $dataImage[$i]['alt']      = $match[1] ?? null;
                $dataImage[$i]['title']    = $match[1] ?? null;
                ++$i;
            }
            /* duyệt mảng => thay thế */
            $tmp            = [];
            foreach($dataImage as $image){
                $dataSrc    = $image['data-src'] ?? $image['src'];
                $tmp        = '<img src="'.config('image.loading_main').'" data-src="'.$dataSrc.'" alt="'.$image['alt'].'" title="'.$image['title'].'" style="width:100%;" />';
                $content    = str_replace($image['source'], $tmp, $content);
            }
        }
        return $content;
    }

}
