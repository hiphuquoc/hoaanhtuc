<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Page;

class HomeController extends Controller{
    public static function home(Request $request){
        $item                   = Page::select('*')
                                    ->whereHas('type', function($query){
                                        $query->where('code', 'home');
                                    })
                                    ->whereHas('seo', function($query){
                                        $query->where('slug', '/');
                                    })
                                    ->with('seo', 'type')
                                    ->first();
        $promotionProducts      = Product::select('*')
                                    ->whereHas('prices', function($query){
                                        $query->where('sale_off', '>', 0);
                                    })
                                    ->paginate(20);
        $newProducts            = Product::select('*')
                                    ->orderBy('id', 'DESC')
                                    ->paginate(20);
        $hotProducts            = Product::select('*')
                                    ->orderBy('sold', 'DESC')
                                    ->paginate(20);
        $categories             = Category::select('*')
                                    ->whereHas('seo', function($query){
                                        $query->where('level', 1);
                                    })
                                    ->join('seo', 'seo.id', '=', 'category_info.seo_id')
                                    ->orderBy('seo.ordering', 'DESC')
                                    ->get();
        $blogs                  = Blog::select('*')
                                    ->whereHas('categories.infoCategory.seo', function($query){
                                        $query->where('slug', 'blog-lam-dep');
                                    })
                                    ->with('seo')
                                    ->get();
        return view('main.home.index', compact('item', 'categories', 'newProducts', 'hotProducts', 'promotionProducts', 'blogs'));
    }

    public static function category(){
        return view('main.category.index');
    }

    public static function product(){
        return view('main.product.index');
    }
}
