<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Upload;
use App\Http\Requests\ProductRequest;
use App\Models\Seo;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductContent;
use App\Models\ProductPrice;
use App\Models\RelationCategoryProduct;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\GalleryController;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class ProductController extends Controller {

    public function __construct(BuildInsertUpdateModel $BuildInsertUpdateModel){
        $this->BuildInsertUpdateModel  = $BuildInsertUpdateModel;
    }

    public function create(ProductRequest $request){
        try {
            DB::beginTransaction();
            /* upload image */
            $dataPath           = [];
            if($request->hasFile('image')) {
                $name           = !empty($request->get('slug')) ? $request->get('slug') : time();
                $dataPath       = Upload::uploadThumnail($request->file('image'), $name);
            }
            /* insert page */
            $insertSeo          = $this->BuildInsertUpdateModel->buildArrayTableSeo($request->all(), 'product_info', $dataPath);
            $seoId              = Seo::insertItem($insertSeo);
            /* insert product_info */
            $idProduct          = Product::insertItem([
                'seo_id'        => $seoId,
                'brand_id'      => $request->get('brand'),
                'code'          => $request->get('code'),
                'name'          => $request->get('name'),
                'description'   => $request->get('description')
            ]);
            /* insert product_content */
            foreach($request->get('contents') as $content){
                ProductContent::insertItem([
                    'product_info_id'   => $idProduct,
                    'name'              => $content['name'],
                    'content'           => $content['content']
                ]);
            }
            /* insert product_price */
            foreach($request->get('prices') as $price){
                $insertPrice    = $this->BuildInsertUpdateModel->buildArrayTableProductPrice($price, $idProduct);
                ProductPrice::insertItem($insertPrice);
            }
            /* danh m???c s???n ph???m */
            foreach($request->get('categories') as $category){
                RelationCategoryProduct::insertItem([
                    'product_info_Id'   => $idProduct,
                    'category_info_id'  => $category
                ]);
            }
            /* insert slider v?? l??u CSDL */
            if($request->hasFile('slider')&&!empty($idProduct)){
                $name           = !empty($request->get('slug')) ? $request->get('slug') : time();
                $params         = [
                    'attachment_id'     => $idProduct,
                    'relation_table'    => 'product_info',
                    'name'              => $name
                ];
                SliderController::upload($request->file('slider'), $params);
            }
            DB::commit();
            /* Message */
            $message        = [
                'type'      => 'success',
                'message'   => '<strong>Th??nh c??ng!</strong> D?? t???o S???n ph???m m???i'
            ];
        } catch (\Exception $exception){
            DB::rollBack();
            /* Message */
            $message        = [
                'type'      => 'danger',
                'message'   => '<strong>Th???t b???i!</strong> C?? l???i x???y ra, vui l??ng th??? l???i'
            ];
        }
        $request->session()->put('message', $message);
        return redirect()->route('admin.product.view', ['id' => $idProduct]);
    }

    public function update(ProductRequest $request){
        try {
            DB::beginTransaction();
            $idSeo              = $request->get('seo_id');
            $idProduct          = $request->get('product_info_id');
            /* upload image */
            $dataPath           = [];
            if($request->hasFile('image')) {
                $name           = !empty($request->get('slug')) ? $request->get('slug') : time();
                $dataPath       = Upload::uploadThumnail($request->file('image'), $name);
            }
            /* update page */
            $insertSeo          = $this->BuildInsertUpdateModel->buildArrayTableSeo($request->all(), 'product_info', $dataPath);
            Seo::updateItem($idSeo, $insertSeo);
            /* insert product_info */
            Product::updateItem($idProduct, [
                'brand_id'      => $request->get('brand'),
                'code'          => $request->get('code'),
                'name'          => $request->get('name'),
                'description'   => $request->get('description')
            ]);
            /* insert product_content */
            ProductContent::select('*')
                                ->where('product_info_id', $idProduct)
                                ->delete();
            foreach($request->get('contents') as $content){
                ProductContent::insertItem([
                    'product_info_id'   => $idProduct,
                    'name'              => $content['name'],
                    'content'           => $content['content']
                ]);
            }
            /* update product_price 
                => x??a c??c product_price n??o id kh??ng t???n t???i trong m???ng m???i 
                => n??o c?? t???n t???i th?? update - n??o kh??ng th?? th??m m???i 
            */
            $priceSave          = [];
            foreach($request->get('prices') as $price){
                if(!empty($price['id'])) $priceSave[]   = $price['id'];
            }
            $productPriceDelete = ProductPrice::select('*')
                                    ->where('product_info_id', $idProduct)
                                    ->whereNotIn('id', $priceSave)
                                    ->with('files')
                                    ->get();
            /* duy???t m???ng delete files */
            foreach($productPriceDelete as $productPrice) {
                foreach($productPrice->files as $file) Gallerycontroller::removeById($file->id);
                /* x??a product price */
                $productPrice->delete();
            }
            /* update l???i c??c product price c??n l???i */
            foreach($request->get('prices') as $price){
                if(!empty($price['name'])&&!empty($price['price'])&&!empty($price['price_origin'])){
                    $dataPrice              = $this->BuildInsertUpdateModel->buildArrayTableProductPrice($price, $idProduct);
                    if(!empty($price['id'])){
                        /* update */
                        ProductPrice::updateItem($price['id'], $dataPrice);
                    }else {
                        /* insert */
                        ProductPrice::insertItem($dataPrice);
                    }
                }
            }
            /* danh m???c s???n ph???m */
            RelationCategoryProduct::select('*')
                                        ->where('product_info_id', $idProduct)
                                        ->delete();
            foreach($request->get('categories') as $category){
                RelationCategoryProduct::insertItem([
                    'product_info_Id'   => $idProduct,
                    'category_info_id'  => $category
                ]);
            }
            /* insert slider v?? l??u CSDL */
            if($request->hasFile('slider')&&!empty($idProduct)){
                $name           = !empty($request->get('slug')) ? $request->get('slug') : time();
                $params         = [
                    'attachment_id'     => $idProduct,
                    'relation_table'    => 'product_info',
                    'name'              => $name
                ];
                SliderController::upload($request->file('slider'), $params);
            }
            DB::commit();
            /* Message */
            $message        = [
                'type'      => 'success',
                'message'   => '<strong>Th??nh c??ng!</strong> ???? c???p nh???t S???n ph???m!'
            ];
        } catch (\Exception $exception){
            DB::rollBack();
            /* Message */
            $message        = [
                'type'      => 'danger',
                'message'   => '<strong>Th???t b???i!</strong> C?? l???i x???y ra, vui l??ng th??? l???i'
            ];
        }
        $request->session()->put('message', $message);
        return redirect()->route('admin.product.view', ['id' => $idProduct]);
    }

    public static function view(Request $request){
        $message            = $request->get('message') ?? null;
        $id                 = $request->get('id') ?? 0;
        $item               = Product::select('*')
                                ->where('id', $id)
                                ->with(['files' => function($query){
                                    $query->where('relation_table', 'product_info');
                                }])
                                ->with('seo', 'contents', 'prices.files', 'categories', 'brand')
                                ->first();
        $categories         = Category::all();
        $brands             = Brand::all();
        $parents            = $categories;
        /* type */
        $type               = !empty($item) ? 'edit' : 'create';
        $type               = $request->get('type') ?? $type;
        return view('admin.product.view', compact('item', 'type', 'categories', 'brands', 'parents', 'message'));
    }

    public static function list(Request $request){
        $params                         = [];
        /* Search theo t??n */
        if(!empty($request->get('search_name'))) $params['search_name'] = $request->get('search_name');
        /* Search theo nh??n h??ng */
        if(!empty($request->get('search_brand'))) $params['search_brand'] = $request->get('search_brand');
        /* Search theo danh m???c */
        if(!empty($request->get('search_category'))) $params['search_category'] = $request->get('search_category');
        /* paginate */
        $viewPerPage        = Cookie::get('viewProductInfo') ?? 20;
        $params['paginate'] = $viewPerPage;
        $list               = Product::getList($params);
        $brands             = Brand::all();
        $categories         = Category::all();
        return view('admin.product.list', compact('list', 'brands', 'categories', 'viewPerPage', 'params'));
    }

    public function delete(Request $request){
        if(!empty($request->get('id'))){
            try {
                DB::beginTransaction();
                $id         = $request->get('id');
                $info       = Product::select('*')
                                ->where('id', $id)
                                ->with('seo', 'prices.files')
                                ->first();
                /* x??a ???nh ?????i di???n s???n ph???m trong th?? m???c */
                $imageSmallPath     = Storage::path(config('admin.images.folderUpload').basename($info->seo->image_small));
                if(file_exists($imageSmallPath)) @unlink($imageSmallPath);
                $imagePath          = Storage::path(config('admin.images.folderUpload').basename($info->seo->image));
                if(file_exists($imagePath)) @unlink($imagePath);
                /* x??a ???nh c???a product_price */
                foreach($info->prices as $price){
                    foreach($price->files as $file){
                        GalleryController::removeById($file->id);
                    }
                }
                /* x??a b???ng product_price */
                $info->prices()->delete();
                /* delete b???ng seo c???a product_info */
                $info->seo()->delete();
                /* x??a product_info */
                $info->delete();
                DB::commit();
                return true;
            } catch (\Exception $exception){
                DB::rollBack();
                return false;
            }
        }
    }

    public static function uploadImageProductPriceAjax(Request $request){
        $result             = [];
        $idProductPrice     = $request->get('product_price_id') ?? 0;
        if(!empty($idProductPrice)&&$request->hasFile('files')){
            $files          = $request->file('files');
            $name           = $request->get('slug') ?? time();
            $params         = [
                'attachment_id'     => $idProductPrice,
                'relation_table'    => 'product_price',
                'name'              => $name
            ];
            $result         = GalleryController::upload($files, $params);
        }
        return json_encode($result);
    }
}
