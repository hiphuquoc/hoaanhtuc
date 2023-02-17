<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Helpers\Url;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;

class PageController extends Controller{

    public static function saleOff(){
        /* thông tin Page */
        $item           = Page::select('*')
            ->whereHas('seo', function($query){
                $query->where('slug', 'san-pham-khuyen-mai');
            })
            ->with('seo', 'files')
            ->first();
        /* danh sách product */
        $products       = Product::select('*')
                ->whereHas('prices', function($query) {
                    $query->where('sale_off', '!=', 0);
                })
                ->with('seo', 'files', 'prices', 'contents', 'categories', 'brand.seo')
                ->get();
        /* lấy thông tin nghành hàng của tất cả sản phẩm trong category */
        $brands             = new \Illuminate\Database\Eloquent\Collection;
        foreach($products as $product){
            if (!$brands->contains('id', $product->brand->id)){
                $brands[]   = $product->brand;
            }
        }
        /* danh sách tất cả category của những sản phẩm trên */
        $categories     = new \Illuminate\Database\Eloquent\Collection;
        foreach($products as $product){
            foreach($product->categories as $category){
                if (!$categories->contains('id', $category->infoCategory->id)){
                    $categories[]   = $category->infoCategory;
                }
            }
        }
        /* breadcrumb */
        $breadcrumb     = Url::buildBreadcrumb($item->seo->slug_full);
        return view('main.category.index', compact('item', 'products', 'breadcrumb', 'brands', 'categories'));
    }

}
