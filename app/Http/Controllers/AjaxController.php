<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestInfo;
use App\Models\Customer;
use App\Models\District;
use App\Models\ServicePrice;
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
