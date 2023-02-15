<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
 


class SettingController extends Controller {

    public function view(Request $request){
        if(!empty($request->get('name')&&!empty($request->get('default')))){
            Cookie::queue($request->get('name'), $request->get('default'), 86400);
        }
    }
    
}
