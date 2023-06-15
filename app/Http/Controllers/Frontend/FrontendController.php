<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Product_featured_photo;
use App\Models\Product_inventory;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Blog_category;
use App\Models\Blog_comment;
use App\Models\Cart;
use App\Models\Childcategory;
use App\Models\Contact_message;
use App\Models\Default_setting;
use App\Models\Faq;
use App\Models\Flashsale;
use App\Models\Order_summery;
use App\Models\Page_setting;
use App\Models\Review;
use App\Models\Subcategory;
use App\Models\Subscriber;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $brands = Brand::where('status', 'Yes')->inRandomOrder()->get();
        $products = Product::where('status', 'Yes')->get();
        $today_deal_products = Product::where('status', 'Yes')->where('today_deal_status', 'Yes')->limit(20)->get();
        $new_products = Product::where('status', 'Yes')->where('created_at', '>', Carbon::now()->subDays(7))->limit(20)->get();
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(20)->get();
        $random_products = Product::where('status', 'Yes')->inRandomOrder()->limit(20)->get();
        $blogs = Blog::where('status', 'Yes')->get();
        $sliders = Slider::where('status', 'Yes')->get();
        $features = Feature::where('status', 'Yes')->get();
        $banners = Banner::where('status', 'Yes')->get();

        $top_selling = Product::leftJoin('order_details','products.id','=','order_details.product_id')
            ->selectRaw('products.id, COALESCE(sum(order_details.cart_qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total','desc')
            ->limit(5)
            ->get();

        $top_selling_products = [];
        foreach($top_selling as $top_sell){
            $top_product = Product::find($top_sell->id);
            $top_product->total_qty = $top_sell->total;
            $top_selling_products[] = $top_product;
        }

        return view('frontend.index', compact('categories', 'subcategories', 'brands', 'products', 'blogs', 'sliders', 'features', 'today_deal_products', 'random_products', 'top_selling_products', 'top_view_products', 'new_products', 'banners'));
    }

    public function fetchHeaderCart()
    {
        $send_carts_sub_total = "00";
        if (Auth::check()) {
            $sub_total = Cart::where('user_id', Auth::user()->id)->get();
            foreach($sub_total as $total){
                $send_carts_sub_total += ($total->product_current_price * $total->cart_qty);
            }
        } else {
            $send_carts_sub_total = "00";
        }

        if (Auth::check()) {
            $send_carts_count = Cart::where('user_id', Auth::user()->id)->count();
        } else {
            $send_carts_count = 0;
        }

        $send_carts_data = "";

        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)->get();
            if ($carts->count() != 0) {
                foreach ($carts as $cart){
                    $send_carts_data .= '
                    <div class="cart__item d-flex justify-content-between align-items-center">
                        <div class="cart__inner d-flex">
                            <div class="cart__thumb">
                                <a href="'.route('product.details', $cart->relationtoproduct->product_slug).'">
                                    <img src="'.asset('uploads/product_thumbnail_photo').'/'.$cart->relationtoproduct->product_thumbnail_photo.'"
                                        alt="">
                                </a>
                            </div>
                            <div class="cart__details">
                                <h6><a href="'.route('product.details', $cart->relationtoproduct->product_slug).'">'.$cart->relationtoproduct->product_name.'</a></h6>
                                <div class="cart__price">
                                    <span>৳
                                    '.$cart->product_current_price.' * '.$cart->cart_qty.'
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="cart__del">
                            <button type="button" id="'.$cart->id.'" class="deleteHeaderCartBtn"><i class="fal fa-times"></i></button>
                        </div>
                    </div>
                    ';
                }
            } else {
                $send_carts_data .='
                <div class="text-center mt-2">
                <span class="text-danger"> Cart Item Not Found.</span>
            </div>
               ';
            }
        } else {
            $send_carts_data .='
            <div class="text-center mt-2">
                <span class="text-danger"> Cart Item Not Found. Please Login First.</span>
            </div>
            ';
        }

        return response()->json([
            'cart_data' => $send_carts_data,
            'cart_count' => $send_carts_count,
            'cart_sub_total' => $send_carts_sub_total,
        ]);
    }

    public function allProduct()
    {
        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $childcategories = Childcategory::where('status', 'Yes')->get();
        $brands = Brand::where('status', "Yes")->get();
        $products = Product::where('status', "Yes")->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.all-product', compact('products', 'categories', 'subcategories' , 'childcategories', 'brands', 'top_view_products'));
    }

    public function productFiltering(Request $request)
    {
        $products = "";
        $filter_products = Product::where('status', "Yes");

        if($request->flashsale_id){
            $filter_products = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $request->flashsale_id);
        }

        if($request->search_data){
            $filter_products->orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->search_data.'%');
        }

        if ($request->category_id) {
            $filter_products->where('category_id', $request->category_id);
        }
        if ($request->subcategory_id) {
            $filter_products->where('subcategory_id', $request->subcategory_id);
        }
        if ($request->childcategory_id) {
            $filter_products->where('childcategory_id', $request->childcategory_id);
        }
        if ($request->brand_id) {
            $filter_products->where('brand_id', $request->brand_id);
        }
        if ($request->sort_by == 'Latest') {
            $filter_products->orderBy('id', 'DESC');
        }
        if ($request->sort_by == 'Oldest') {
            $filter_products->orderBy('id', 'ASC');
        }
        if ($request->sort_by == 'Price-desc') {
            $filter_products->orderBy('discounted_price', 'DESC');
        }
        if ($request->sort_by == 'Price-asc') {
            $filter_products->orderBy('discounted_price', 'ASC');
        }

        $products = $filter_products->paginate(16);

        return view('frontend.part.product-list', compact('products'))->render();
    }

    public function productFilteringBrand(Request $request)
    {
        $products_result = "";
        $filter_products = Product::where('status', "Yes");

        if($request->flashsale_id){
            $filter_products = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $request->flashsale_id);
        }

        if($request->search_data){
            $filter_products->orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->search_data.'%');
        }

        if ($request->category_id) {
            $filter_products->where('category_id', $request->category_id);
        }
        if ($request->subcategory_id) {
            $filter_products->where('subcategory_id', $request->subcategory_id);
        }
        if ($request->childcategory_id) {
            $filter_products->where('childcategory_id', $request->childcategory_id);
        }

        $products_result = $filter_products;

        $brands_result = $products_result->select('brand_id')->groupBy('brand_id')->get();

        return view('frontend.part.brand-list', compact('brands_result'))->render();
    }

    public function productBrandWiseFiltering(Request $request)
    {

        $products = "";
        $filter_products = Product::where('status', "Yes");

        if($request->flashsale_id){
            $filter_products = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $request->flashsale_id);
        }

        if($request->search_data){
            $filter_products->orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->search_data.'%');
        }

        if ($request->category_id) {
            $filter_products->where('category_id', $request->category_id);
        }
        if ($request->subcategory_id) {
            $filter_products->where('subcategory_id', $request->subcategory_id);
        }
        if ($request->childcategory_id) {
            $filter_products->where('childcategory_id', $request->childcategory_id);
        }
        if ($request->sort_by == 'Latest') {
            $filter_products->orderBy('id', 'DESC');
        }
        if ($request->sort_by == 'Oldest') {
            $filter_products->orderBy('id', 'ASC');
        }
        if ($request->sort_by == 'Price-desc') {
            $filter_products->orderBy('discounted_price', 'DESC');
        }
        if ($request->sort_by == 'Price-asc') {
            $filter_products->orderBy('discounted_price', 'ASC');
        }

        if ($request->all_brand_id) {
            $brand_id = explode( ',', $request->all_brand_id );
            $filter_products->whereIn('brand_id', $brand_id);
        }

        $products = $filter_products->paginate(16);

        return view('frontend.part.product-list', compact('products'))->render();
    }

    public function quickViewProduct($id)
    {
        $product = Product::where('id', $id)->first();
        $product_reviews = Review::where('product_id', $product->id)->get();
        return view('frontend.product.quick-view-product', compact('product', 'product_reviews'));
    }

    public function productDetails($product_slug)
    {
        Product::where('status', 'Yes')->where('product_slug', $product_slug)->increment('view_count');
        $product = Product::where('status', 'Yes')->where('product_slug', $product_slug)->first();
        $product_featured_photos = Product_featured_photo::where('product_id', $product->id)->get();
        $sum_quantity_inventories = Product_inventory::where('product_id', $product->id)->sum('quantity');
        $related_products = Product::where('subcategory_id', $product->subcategory_id)->where('id', '!=', $product->id)->get();
        $product_reviews = Review::where('product_id', $product->id)->get();
        $product_inventories = Product_inventory::where('product_id', $product->id)->select('color_id')->groupBy('color_id')->get();

        return view('frontend.product.product-details', compact('product', 'product_reviews', 'product_featured_photos', 'related_products', 'sum_quantity_inventories', 'product_inventories'));
    }

    public function getSizes(Request $request)
    {
        $send_sizes = "";
        $model_send_sizes = "";
        $sizes = Product_inventory::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
        ])->get();

        foreach($sizes as $size){
            $send_sizes .= "<span id='$size->size_id' class='border details_select_size'>".$size->relationtosize->size_name."</span>";
            $model_send_sizes .= "<span id='$size->size_id' class='border model_select_size'>".$size->relationtosize->size_name."</span>";
        }

        $sizes_count = $sizes->count();

        $send_qty = Product_inventory::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
        ])->sum('quantity');

        return response()->json([
            'model_send_sizes' => $model_send_sizes,
            'send_sizes' => $send_sizes,
            'send_qty' => $send_qty,
            'sizes_count' => $sizes_count,
        ]);
    }

    public function getQuantity(Request $request)
    {
        $send_qty = Product_inventory::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ])->first()->quantity;

        return response()->json([
            'send_qty' => $send_qty,
        ]);
    }

    public function findProduct(Request $request)
    {
        $find_products = "";
        $products = Product::orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->search.'%')->limit(8)->get();
        if ($products->count() > 0) {
            foreach ($products as $product){
                $find_products .= '
                <a href="'.route('product.details', $product->product_slug).'">
                    <li>
                        <img src="'.asset('uploads/product_thumbnail_photo').'/'.$product->product_thumbnail_photo.'" alt="">
                        <p>'.$product->product_name.'</p>
                    </li>
                </a>
                ';
            }
        } else {
            $find_products .= '
                <li>
                    <strong class="text-danger p-2">Result Not Found</strong>
                </li>
            ';
        }

        return response()->json($find_products);
    }

    public function searchProducts(Request $request)
    {
        $search_data = $request->product_name;

        $products = "";
        $search_products = Product::orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->product_name.'%');
        if($request->category_id != "ALL"){
            $products = $search_products->where('category_id', $request->category_id);
        }
        $products = $search_products->paginate(16);

        $categories = $search_products->select('category_id')->groupBy('category_id')->get();
        $subcategories = $search_products->select('subcategory_id')->groupBy('subcategory_id')->get();
        $childcategories = $search_products->select('childcategory_id')->groupBy('childcategory_id')->get();
        $brands = Product::orderBy('id', 'desc')->where('product_name', 'LIKE', '%'.$request->product_name.'%')->select('brand_id')->groupBy('brand_id')->get();

        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.search-product', compact( 'search_data', 'products', 'top_view_products', 'categories', 'subcategories', 'childcategories', 'brands'));
    }

    public function categoryWiseProduct(Request $request, $slug)
    {
        $category = Category::where('category_slug', $slug)->first();

        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->where('category_id', $category->id)->get();
        $childcategories = Childcategory::where('status', 'Yes')->where('category_id', $category->id)->get();
        $brands = Product::where('status', 'Yes')->where('category_id', $category->id)->select('brand_id')->groupBy('brand_id')->get();
        $products = Product::where('status', "Yes")->where('category_id', $category->id)->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.category-wise-product', compact('category', 'categories', 'subcategories','childcategories', 'brands', 'products', 'top_view_products'));
    }

    public function subcategoryWiseProduct($slug)
    {
        $subcategory = Subcategory::where('subcategory_slug', $slug)->first();

        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $childcategories = Childcategory::where('status', 'Yes')->where('subcategory_id', $subcategory->id)->get();
        $brands = Product::where('status', 'Yes')->where('subcategory_id', $subcategory->id)->select('brand_id')->groupBy('brand_id')->get();
        $products = Product::where('status', 'Yes')->where('subcategory_id', $subcategory->id)->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.subcategory-wise-product', compact('subcategory', 'subcategories', 'categories', 'childcategories', 'brands', 'products', 'top_view_products'));
    }

    public function childcategoryWiseProduct($slug)
    {
        $categories = Category::where('status', 'Yes')->get();
        $childcategory = Childcategory::where('childcategory_slug', $slug)->first();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $childcategories = Childcategory::where('status', 'Yes')->get();
        $brands = Product::where('status', 'Yes')->where('childcategory_id', $childcategory->id)->select('brand_id')->groupBy('brand_id')->get();
        $products = Product::where('status', 'Yes')->where('childcategory_id', $childcategory->id)->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.childcategory-wise-product', compact('childcategory', 'subcategories', 'childcategories', 'categories', 'brands', 'products', 'top_view_products'));
    }

    public function brandWiseProduct($slug)
    {
        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $childcategories = Childcategory::where('status', 'Yes')->get();
        $brand = Brand::where('brand_slug', $slug)->first();
        $brands = Brand::where('status', 'Yes')->get();
        $products = Product::where('brand_id', $brand->id)->where('status', 'Yes')->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.brand-wise-product', compact('brand', 'brands', 'products', 'subcategories', 'childcategories', 'categories', 'top_view_products'));
    }

    public function flashsaleProduct($slug)
    {
        $flashsale = Flashsale::where('status', 'Yes')->where('flashsale_offer_slug', $slug)->first();

        $categories = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $flashsale->id)->select('category_id')->groupBy('category_id')->get();
        $subcategories = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $flashsale->id)->select('subcategory_id')->groupBy('subcategory_id')->get();
        $childcategories = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $flashsale->id)->select('childcategory_id')->groupBy('childcategory_id')->get();
        $brands = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $flashsale->id)->select('brand_id')->groupBy('brand_id')->get();

        $products = Product::where('flashsale_status', 'Yes')->where('status', 'Yes')->where('flashsale_id', $flashsale->id)->paginate(16);
        $top_view_products = Product::where('status', 'Yes')->orderBy('view_count', 'DESC')->limit(8)->get();
        return view('frontend.product.flashsale-product', compact('categories', 'subcategories', 'childcategories', 'products', 'brands', 'flashsale', 'top_view_products'));
    }


    public function allCategory()
    {
        $categories = Category::where('status', 'Yes')->get();
        $subcategories = Subcategory::where('status', 'Yes')->get();
        $childcategories = Childcategory::where('status', 'Yes')->get();
        return view('frontend.all-category', compact('categories', 'subcategories', 'childcategories'));
    }

    public function allBrand()
    {
        $brands = Brand::where('status', "Yes")->get();
        return view('frontend.all-brand', compact('brands'));
    }

    public function allFlashsale()
    {
        $flashsales = Flashsale::where('status', "Yes")->Where('flashsale_offer_start_date', '<', Carbon::now())->Where('flashsale_offer_end_date', '>', Carbon::now())->get();
        return view('frontend.all-flashsale', compact('flashsales'));
    }

    public function allBlog()
    {
        $blogs = Blog::where('status', 'Yes')->paginate(8);
        $top_view_blog = Blog::where('status', 'Yes')->orderBy('view_count', 'DESC')->get();
        $blog_categories = Blog_category::where('status', 'Yes')->get();
        return view('frontend.blog.all-blog', compact('blogs', 'top_view_blog', 'blog_categories'));
    }

    public function categoryWiseBlog($slug)
    {
        $blog_category = Blog_category::where('blog_category_slug', $slug)->first();
        $blogs = Blog::where('status', "Yes")->where('blog_category_id', $blog_category->id)->paginate(8);
        $top_view_blog = Blog::where('status', 'Yes')->orderBy('view_count', 'DESC')->get();
        $blog_categories = Blog_category::where('status', 'Yes')->get();
        return view('frontend.blog.category-wise-blog', compact('blog_category', 'blogs', 'top_view_blog', 'blog_categories'));
    }

    public function blogDetails($blog_slug)
    {
        Blog::where('status', 'Yes')->where('blog_slug', $blog_slug)->increment('view_count');
        $blog = Blog::where('status', 'Yes')->where('blog_slug', $blog_slug)->first();
        $comments = Blog_comment::where('blog_id', $blog->id)->get();
        $top_view_blog = Blog::where('status', 'Yes')->orderBy('view_count', 'DESC')->get();
        $blog_categories = Blog_category::where('status', 'Yes')->get();
        return view('frontend.blog.blog-details', compact('blog', 'comments', 'top_view_blog', 'blog_categories'));
    }

    public function findBlog(Request $request)
    {
        $find_blogs = "";
        $blogs = Blog::orderBy('id', 'desc')->where('blog_headline', 'LIKE', '%'.$request->search.'%')->limit(8)->get();
        if ($blogs->count() > 0) {
            foreach ($blogs as $blog){
                $find_blogs .= '
                <a href="'.route('blog.details', $blog->blog_slug).'">
                    <li>
                        <img src="'.asset('uploads/blog_thumbnail_photo').'/'.$blog->blog_thumbnail_photo.'" alt="">
                        <p>'.$blog->blog_headline.'</p>
                    </li>
                </a>
                ';
            }
        } else {
            $find_blogs .= '
                <li>
                    <strong class="text-danger p-2">Result Not Found</strong>
                </li>
            ';
        }

        return response()->json($find_blogs);
    }

    public function searchBlogs(Request $request)
    {
        $blog_categories = Blog_category::where('status', 'Yes')->get();

        $blogs = Blog::orderBy('id', 'desc')->where('blog_headline', 'LIKE', '%'.$request->blog_headline.'%')->paginate(8);

        $top_view_blog = Blog::where('status', 'Yes')->orderBy('view_count', 'DESC')->get();
        return view('frontend.blog.search-blog', compact('blogs', 'blog_categories', 'top_view_blog'));
    }

    public function blogCommentPost(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        Blog_comment::insert([
            'blog_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }

    public function subscribePost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subscriber_email' => 'required|email|unique:subscribers'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Subscriber::insert([
                'subscriber_email' => $request->subscriber_email,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status'=>200
            ]);
        }
    }

    public function page($slug)
    {
        $page = Page_setting::where('page_slug', $slug)->first();
        return view('frontend.page', compact('page'));
    }

    public function orderTracking()
    {
        return view('frontend.order-tracking');
    }

    public function checkOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            if (User::where('email', $request->order_email)->exists()) {
                $user = User::where('email', $request->order_email)->first();
                if (Order_summery::where('id', $request->order_number)->where('user_id', $user->id)->exists()) {
                    $order_status = "";
                    $order_summery = Order_summery::where('id', $request->order_number)->where('user_id', $user->id)->first();
                    $order_status .= '
                        <li><strong>Sub Total: </strong> <span class="badge bg-dark">'.$order_summery->sub_total.'</span></li>
                        <li><strong>Discount Amount: </strong> <span class="badge bg-dark">'.$order_summery->discount_amount.'</span></li>
                        <li><strong>Shipping Charge: </strong> <span class="badge bg-dark">'.$order_summery->shipping_charge.'</span></li>
                        <li><strong>Grand Total: </strong> <span class="badge bg-dark">'.$order_summery->grand_total.'</span></li>
                        <li><strong>Payment Method: </strong> <span class="badge bg-info">'.$order_summery->payment_method.'</span></li>
                        <li><strong>Payment Status: </strong> <span class="badge bg-primary">'.$order_summery->payment_status.'</span></li>
                        <li><strong>Order Status: </strong> <span class="badge bg-success">'.$order_summery->order_status.'</span></li>
                        <li><strong>Order Date: </strong> <span class="badge bg-warning">'.$order_summery->created_at->format('d-M,Y h:m:s A').'</span></li>
                    ';
                    return response()->json([
                        'status' => 200,
                        'order_status' => $order_status,
                    ]);
                } else {
                    return response()->json([
                        'status' => 402,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                ]);
            }
        }
    }

    public function about()
    {
        $teams = Team::where('status', 'Yes')->get();
        return view('frontend.about', compact('teams'));
    }

    public function faqs()
    {
        $faqs = Faq::where('status', 'Yes')->get();
        return view('frontend.faqs', compact('faqs'));
    }

    public function contact()
    {
        $default_setting = Default_setting::first();
        return view('frontend.contact', compact('default_setting'));
    }

    public function contactMessageSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email_address' => 'required',
            'phone_number' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Contact_message::insert($request->except('_token')+[
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
            ]);
        }
    }

}

