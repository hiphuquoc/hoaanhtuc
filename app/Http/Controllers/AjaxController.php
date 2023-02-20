<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\District;
use App\Models\Product;
use App\Models\RegistryEmail;
// use App\Services\BuildInsertUpdateModel;

class AjaxController extends Controller {

    // public function __construct(BuildInsertUpdateModel $BuildInsertUpdateModel){
    //     $this->BuildInsertUpdateModel  = $BuildInsertUpdateModel;
    // }

    public static function loadLoading(){
        $xhtml      = view('main.template.loading')->render();
        echo $xhtml;
    }

    public static function loadDistrictByIdProvince(Request $request){
        $response           = '<option value="0" selected>- Vui lòng chọn -</option>';
        if(!empty($request->get('province_info_id'))){
            $districts      = District::select('*')
                                ->where('province_id', $request->get('province_info_id'))
                                ->get();
            foreach($districts as $district){
                $response   .= '<option value="'.$district->id.'">'.$district->district_name.'</option>';
            }
        }
        echo $response;
    }

    public static function searchProductAjax(Request $request){
        if(!empty($request->get('key_search'))){
            $keySearch          = \App\Helpers\Charactor::convertStringSearch($request->get('key_search'));
            $products           = Product::select('product_info.*')
                ->join('seo', 'seo.id', '=', 'product_info.seo_id')
                ->where('name', 'like', '%'.$keySearch.'%')
                ->skip(0)
                ->take(6)
                ->with('seo')
                ->orderBy('seo.ordering', 'DESC')
                ->get();
            $count              = Product::select('product_info.*')
                ->where('name', 'like', '%'.$keySearch.'%')
                ->count();
            $response           = null;
            if(!empty($products)&&$products->isNotEmpty()){
                foreach($products as $product){
                    $title      = $product->name ?? $product->seo->title ?? null;
                    $priceOld   = null;
                    if($product->prices[0]->price<$product->prices[0]->price_before_promotion) $priceOld = '<div class="searchViewBefore_selectbox_item_content_price_old">'.number_format($product->prices[0]->price_before_promotion).config('main.currency_unit').'</div>';
                    $response       .= '<a href="/'.$product->seo->slug_full.'" class="searchViewBefore_selectbox_item">
                                            <div class="searchViewBefore_selectbox_item_image">
                                                <img src="'.Storage::url($product->prices[0]->files[0]->file_path).'" alt="'.$title.'" title="'.$title.'" />
                                            </div>
                                            <div class="searchViewBefore_selectbox_item_content">
                                                <div class="searchViewBefore_selectbox_item_content_title maxLine_2">
                                                    '.$title.'
                                                </div>
                                                <div class="searchViewBefore_selectbox_item_content_price">
                                                    <div>'.number_format($product->prices[0]->price).config('main.currency_unit').'</div>
                                                    '.$priceOld.'
                                                </div>
                                            </div>
                                        </a>';
                }
                $response           .= '<a href="'.route('main.searchProduct').'?key_search='.request('key_search').'" class="searchViewBefore_selectbox_item">
                                            Xem tất cả (<span style="font-size:1.1rem;">'.$count.'</span>) <i class="fa-solid fa-angles-right"></i>
                                        </a>';
            }else {
                $response       = '<div class="searchViewBefore_selectbox_item">Không có sản phẩm phù hợp!</div>';
            }
            echo $response;
        }
    }

    public static function registryEmail(Request $request){
        $flag = false;
        if(!empty($request->get('registry_email'))){
            $idRegistryEmail    = RegistryEmail::insertItem([
                'email'     => $request->get('registry_email')
            ]);
            if(!empty($idRegistryEmail)) $flag = true;
        }
        echo $flag;
    }

    public function buildTocContentMain(Request $request){
        $xhtml       = null;
        if(!empty($request->get('data'))){
            $xhtml   = view('main.template.tocContentMain', ['data' => $request->get('data')])->render();
        }
        echo $xhtml;
    }

    // public function submitFormRequestWebsite(Request $request){
    //     $dataForm       = [];
    //     foreach($request->get('data') as $value){
    //         $dataForm[$value['name']]   = $value['value'];
    //     }
    //     /* insert customer_info */
    //     $insertCustomer = $this->BuildInsertUpdateModel->buildArrayTableCustomerInfo($dataForm);
    //     $idCustomer     = Customer::insertItem($insertCustomer);
    //     /* insert request_info */
    //     $priceService   = ServicePrice::find($dataForm['service_price_id']);
    //     $dataForm['promotion']      = $priceService->sale_off ?? 0;
    //     if(!empty((integer) $priceService->price_origin)){
    //         /* là số */
    //         $dataForm['total']      = $priceService->price_origin*(100-$priceService->sale_off)/100;
    //     }else {
    //         $dataForm['total']      = "không xác định";
    //     }
    //     $insertRequest  = $this->BuildInsertUpdateModel->buildArrayTableRequestInfo($dataForm, $idCustomer);
    //     $idRequest      = RequestInfo::insertItem($insertRequest);
    //     if($idRequest){
    //         $xhtml      = view('main.ajax.notice')->render();
    //         echo $xhtml;
    //     }else {
    //         echo 'error';
    //     }
    // }
}
