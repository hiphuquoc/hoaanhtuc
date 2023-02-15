<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use App\Models\Page;
use App\Models\Product;

class CartController extends Controller{

    public static function index(Request $request){
        $item           = Page::select('*')
                            ->whereHas('seo', function($query){
                                $query->where('slug', 'gio-hang');
                            })
                            ->with('seo', 'type')
                            ->first();
        $products       = \App\Http\Controllers\CartController::getCollectionProducts();
        $productsCart   = json_decode(Cookie::get('cart'), true);
        $breadcrumb     = \App\Helpers\Url::buildBreadcrumb('gio-hang');
        if(!empty($productsCart)){
            return view('main.cart.index', compact('item', 'breadcrumb', 'products', 'productsCart'));
        }else {
            return redirect()->route('main.home');
        }
    }

    public static function addToCart(Request $request){
        /* cart cũ */
        $cartOld        = Cookie::get('cart');
        if(!empty($cartOld)){
            /* trong giỏ hàng đã có sản phẩm */
            $tmp        = json_decode($cartOld, true);
            $flagMatch  = false;
            $cartNew    = [];
            $i          = 0;
            foreach($tmp as $product){
                $cartNew[$i]    = $product;
                /* trường hợp sản phẩm đã có trong giỏ hàng => cộng số lượng */
                if($product['product_info_id']==$request->get('product_info_id')&&$product['product_price_id']==$request->get('product_price_id')){
                    $cartNew[$i]['quantity'] = $cartNew[$i]['quantity'] + $request->get('quantity');
                    $flagMatch  = true;
                }
                ++$i;
            }
            /* trường hợp sản phẩm chưa có trong giỏ hàng => thêm vào mảng */
            if($flagMatch==false) {
                $cartNew[count($cartNew)] = [
                    'product_info_id'   => $request->get('product_info_id'),
                    'product_price_id'  => $request->get('product_price_id'),
                    'quantity'          => $request->get('quantity'),
                    'price'             => $request->get('price')
                ];
            }
        }else {
            /* trong giỏ hàng chưa có sản phẩm */
            $cartNew    = [
                [
                    'product_info_id'   => $request->get('product_info_id'),
                    'product_price_id'  => $request->get('product_price_id'),
                    'quantity'          => $request->get('quantity'),
                    /* ghi cookie thêm price để dễ tính total lúc update cart */
                    'price'             => $request->get('price')
                ]
            ];
        }
        /* set cookie */
        self::setCookie('cart', json_encode($cartNew), 3600);
        /* trả thông báo */
        $result = view('main.cart.cartMessage', $request->all());
        echo $result;
    }

    public static function viewSortCart(){
        $products = self::getCollectionProducts();
        $response = view('main.cart.cartSort', compact('products'))->render();
        echo $response;
    }

    public static function updateCart(Request $request){
        /* lấy dữ liệu cookie của products */
        $tmp            = Cookie::get('cart');
        if(!empty($tmp)) $tmp = json_decode($tmp, true);
        /* cập nhật lại số lượng sản phẩm */
        $products       = [];
        if(!empty($request->get('product_info_id'))&&!empty($request->get('quantity'))){
            $count      = 0;
            $total      = 0;
            $i          = 0;
            foreach($tmp as $product){
                $products[$i]   = $product;
                if($product['product_info_id']==$request->get('product_info_id')&&$product['product_price_id']==$request->get('product_price_id')){
                    $total      += $request->get('quantity')*$products[$i]['price'];
                    $count      += $request->get('quantity');
                    /* cập nhật lại quantity */
                    $products[$i]['quantity']   = $request->get('quantity');
                    /* lấy thông tin product để cập nhật lại giao diện */
                    $infoProduct = self::getCollectionProduct($products[$i]);
                }else {
                    $total += $products[$i]['quantity']*$products[$i]['price'];
                    $count += $products[$i]['quantity'];
                }
                ++$i;
            }
        }
        /* set lại cookie */
        self::setCookie('cart', json_encode($products), 3600);
        /* lấy dữ liệu của cột thay đổi */
        $result['total']        = number_format($total).config('main.currency_unit');
        $result['count']        = $count;
        if($request->get('theme')=='cartSort'){
            $result['row']      = view('main.cart.cartSortRow', ['product' => $infoProduct])->render();
        }else {
            $result['row']      = view('main.cart.cartRow', ['product' => $infoProduct])->render();
        }
        return json_encode($result);
    }

    public static function calculatorTotalInCart(){
        $total          = 0;
        $infoProducts   = self::getCollectionProducts();
        foreach($infoProducts as $infoProduct){
            foreach($infoProduct->prices as $price){
                if($price->id==$infoProduct->product_price_id) $total += $infoProduct->quantity*$price->price;
            }
        }
        return $total;
    }

    public static function removeProductCart(Request $request){
        $tmp                    = Cookie::get('cart');
        if(!empty($tmp)) $tmp = json_decode($tmp, true);
        /* xóa product và tính lại total + count */
        $products               = [];
        $total                  = 0;
        $count                  = 0;
        $i                      = 0;
        foreach($tmp as $product){
            if($product['product_info_id']==$request->get('product_info_id')&&$product['product_price_id']==$request->get('product_price_id')){
                /* không làm gì cả */
            }else {
                $products[$i]   = $product;
                $total          += $product['price']*$product['quantity'];
                $count          += $product['quantity'];
                ++$i;
            }
        }
        /* set lại cookie */
        self::setCookie('cart', json_encode($products), 3600);
        $result['total']        = number_format($total).config('main.currency_unit');
        $result['count']        = $count;
        return json_encode($result);
    }

    public static function getCollectionProducts(){
        $products       = Cookie::get('cart');
        if(!empty($products)) $products = json_decode($products, true);
        /* duyệt từ từ qua mảng để lấy lần lượt product ứng với price */
        $infoProducts       = new \Illuminate\Database\Eloquent\Collection;
        if(!empty($products)){
            foreach($products as $product) {
                $infoProducts[] = self::getCollectionProduct($product);
            }
        }
        return $infoProducts;
    }

    public static function getCollectionProduct($productInCart){
        $idPrice    = $productInCart['product_price_id'];
        $tmp        = Product::select('*')
                            ->whereHas('prices', function($query) use($idPrice){
                                $query->where('id', $idPrice);
                            })
                            ->with('seo', 'prices.files')
                            ->first();
        if(!empty($tmp)){
            /* ghép product_price được chọn vào collection */
            foreach($tmp->prices as $price){
                if($idPrice==$price->id) {
                    $tmp->price = $price;
                    break;
                }
            }
            /* ghép cookie vào collection */
            $tmp->cart      = collect($productInCart);
        }
        /* đưa phần tử collection vào collection cha */
        return $tmp;
    }

    public static function setCookie($name, $value, $time=null){
        $reponse = null;
        if(!empty($name)&&!empty($value)){
            Cookie::queue($name, $value, $time);
        }
        return $reponse;
    }

    public static function removeCookie($name){
        $flag = Cookie::queue($name, null, -3600);
        return $flag;
    }
}
