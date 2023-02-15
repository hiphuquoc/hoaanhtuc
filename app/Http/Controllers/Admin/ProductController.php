<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
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
            /* danh mục sản phẩm */
            foreach($request->get('categories') as $category){
                RelationCategoryProduct::insertItem([
                    'product_info_Id'   => $idProduct,
                    'category_info_id'  => $category
                ]);
            }
            /* insert slider và lưu CSDL */
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
                'message'   => '<strong>Thành công!</strong> Dã tạo Sản phẩm mới'
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
                => xóa các product_price nào id không tồn tại trong mảng mới 
                => nào có tồn tại thì update - nào không thì thêm mới 
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
            /* duyệt mảng delete files */
            foreach($productPriceDelete as $productPrice) {
                foreach($productPrice->files as $file) Gallerycontroller::removeById($file->id);
                /* xóa product price */
                $productPrice->delete();
            }
            /* update lại các product price còn lại */
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
            /* danh mục sản phẩm */
            RelationCategoryProduct::select('*')
                                        ->where('product_info_id', $idProduct)
                                        ->delete();
            foreach($request->get('categories') as $category){
                RelationCategoryProduct::insertItem([
                    'product_info_Id'   => $idProduct,
                    'category_info_id'  => $category
                ]);
            }
            /* insert slider và lưu CSDL */
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
                'message'   => '<strong>Thành công!</strong> Đã cập nhật Sản phẩm!'
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
        /* Search theo tên */
        if(!empty($request->get('search_name'))) $params['search_name'] = $request->get('search_name');
        /* Search theo nhãn hàng */
        if(!empty($request->get('search_brand'))) $params['search_brand'] = $request->get('search_brand');
        /* Search theo danh mục */
        if(!empty($request->get('search_category'))) $params['search_category'] = $request->get('search_category');
        /* paginate */
        $viewPerPage        = Cookie::get('viewProductInfo') ?? 20;
        $params['paginate'] = $viewPerPage;
        $list               = Product::getList($params);
        $brands             = Brand::all();
        $categories         = Category::all();
        return view('admin.product.list', compact('list', 'brands', 'categories', 'viewPerPage', 'params'));
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
