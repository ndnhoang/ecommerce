<?php

namespace App\Http\Controllers;

use App\Category;
use App\Coupon;
use App\Product;
use App\ProductImages;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error', 'Category is missing');
            }
            $product = new Product();
            $product->category_id = $data['category_id'];
            $product->product_name = $data['name'];
            $product->product_code = $data['code'];
            $product->product_color = $data['color'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }
            if (!empty($data['care'])) {
                $product->care = $data['care'];
            } else {
                $product->care = '';
            }
            $product->price = $data['price'];

//            upload image
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $filename;
                    $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                    $small_image_path = 'images/backend_images/products/small/' . $filename;
//                    Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
//                    Store Image name in products table
                    $product->image = $filename;
                }
            } else {
                $product->image = '';
            }

            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }
            $product->status = $status;

            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success', 'Product has been added successfully');
        }

        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $category) {
            $categories_dropdown .= "<option value='" . $category->id . "'>" . $category->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $category->id])->get();
            foreach ($sub_categories as $sub_category) {
                $categories_dropdown .= "<option value='" . $sub_category->id . "'>&nbsp;--&nbsp;" . $sub_category->name . "</option>";
            }
        }

        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProducts()
    {
        $products = Product::get();
        foreach ($products as $key => $value) {
            $category_name = Category::where(['id' => $value->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function editProduct(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_message_error', 'Category is missing');
            }
            if (!empty($data['description'])) {
                $description = $data['description'];
            } else {
                $description = '';
            }

            if (!empty($data['care'])) {
                $care = $data['care'];
            } else {
                $care = '';
            }

            if (empty($data['status'])) {
                $status = 0;
            } else {
                $status = 1;
            }

            $filename = $data['current_image'];
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $filename;
                    $medium_image_path = 'images/backend_images/products/medium/' . $filename;
                    $small_image_path = 'images/backend_images/products/small/' . $filename;
//                    Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                }
            }

            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => $data['name'], 'product_code' => $data['code'], 'product_color' => $data['color'], 'description' => $description, 'care' => $care, 'price' => $data['price'], 'image' => $filename, 'status' => $status]);
            return redirect()->back()->with('flash_message_success', 'Product has been updated successfully');
        }

        $productDetails = Product::where(['id' => $id])->first();

        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' disabled>Select</option>";
        foreach ($categories as $category) {
            if ($category->id == $productDetails->category_id) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='" . $category->id . "' " . $selected . ">" . $category->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $category->id])->get();
            foreach ($sub_categories as $sub_category) {
                if ($sub_category->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='" . $sub_category->id . "' " . $selected . ">&nbsp;--&nbsp;" . $sub_category->name . "</option>";
            }
        }

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }

    public function deleteProduct($id = null)
    {
        Product::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }

    public function deleteProductImage($id = null)
    {
//        get product image name
        $productDetails = Product::where(['id' => $id])->first();
        $productImage = $productDetails->image;

//        get product image path
        $large_image_path = "images/backend_images/products/large/";
        $medium_image_path = "images/backend_images/products/medium/";
        $small_image_path = "images/backend_images/products/small/";

//        delete product image if exists in Folder
        if (file_exists($large_image_path . $productImage)) {
            unlink($large_image_path . $productImage);
        }
        if (file_exists($medium_image_path . $productImage)) {
            unlink($medium_image_path . $productImage);
        }
        if (file_exists($small_image_path . $productImage)) {
            unlink($small_image_path . $productImage);
        }

//        delete product image from Product table
        Product::where(['id' => $id])->update(['image' => '']);

        return redirect()->back()->with('flash_message_success', 'Product Image has been deleted successfully');
    }

    public function addAttributes(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

//                    Prevent duplicate SKU Check
                    $attrCountSKU = ProductsAttribute::where('sku', $value)->count();
                    if ($attrCountSKU > 0) {
                        return redirect('/admin/add-attributes/' . $id)->with('flash_message_error', 'SKU already exists! Please add another SKU');
                    }

//                     Prevent duplicate Size Check
                    $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        return redirect('/admin/add-attributes/' . $id)->with('flash_message_error', $data['size'][$key] . ' Size already exists for this product! Please add another Size');

                    }

                    $attribute = new ProductsAttribute();
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('/admin/add-attributes/' . $id)->with('flash_message_success', 'Product Attributes has been added successfully');
        }

        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function editAttributes(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['idAttr'] as $key => $value) {
                ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Products Attributes has been updated successfully');
        }
    }

    public function deleteAttribute($id = null)
    {
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Attribute has been deleted successfully');
    }

    public function listProductsByCategory($id = null)
    {
//        show 404 page if category url does not exist
        $countCategory = Category::where(['id' => $id])->count();
        if ($countCategory == 0) {
            abort(404);
        }

        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['id' => $id])->first();
        if ($categoryDetails->status == 0) {
            abort(404);
        }

        if ($categoryDetails->parent_id == 0) {
//            if url is main category url
            $subCategories = Category::where(['parent_id' => $id])->get();
            $category_ids = array();
            foreach ($subCategories as $subCategory) {
                $category_ids[] = $subCategory->id;
            }
            $category_ids[] = $id;
            $products = Product::whereIn('category_id', $category_ids)->where('status', 1)->get();
        } else {
//            if url is sub category url
            $products = Product::where(['category_id' => $id])->where('status', 1)->get();
        }

        return view('products.listing')->with(compact('categoryDetails', 'products', 'categories'));
    }

    public function showProductDetails($id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        if ($productDetails->status == 0) {
            abort(404);
        }


        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $productImages = ProductImages::where('product_id', $id)->get();

        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        $relatedProducts = Product::where('id', '!=', $id)->where('status', 1)->where(['category_id' => $productDetails->category_id])->get();

        return view('products.details')->with(compact('productDetails', 'categories', 'productImages', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        $productArr = explode("-", $data['size']);
        $productArr = ProductsAttribute::where(['product_id' => $productArr[0], 'size' => $productArr[1]])->first();
        echo $productArr->price . '#' . $productArr->stock;
    }

    public function addImages(Request $request, $id = null)
    {
        $productDetails = Product::where('id', $id)->first();

        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $image = new ProductImages();
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/products/large/' . $fileName;
                    $medium_image_path = 'images/backend_images/products/medium/' . $fileName;
                    $small_image_path = 'images/backend_images/products/small/' . $fileName;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    $image->image = $fileName;
                    $image->product_id = $id;
                    $image->save();
                }
            }
            return redirect('admin/add-images/' . $id)->with('flash_message_success', 'Product Images has been added successfully');
        }

        $productImages = ProductImages::where('product_id', $id)->get();

        return view('admin.products.add_images')->with(compact('productDetails', 'productImages'));
    }

    public function deleteImages($id = null)
    {
        $image = ProductImages::where('id', $id)->first();
        $large_image_path = 'images/backend_images/products/large/' . $image;
        $medium_image_path = 'images/backend_images/products/small/' . $image;
        $small_image_path = 'images/backend_images/products/medium/' . $image;

        if (file_exists($large_image_path)) {
            unlink($large_image_path);
        }
        if (file_exists($medium_image_path)) {
            unlink($medium_image_path);
        }
        if (file_exists($small_image_path)) {
            unlink($small_image_path);
        }

        ProductImages::where('id', $id)->delete();

        return redirect()->back()->with('flash_message_success', 'Product Images has been deleted successfully');
    }

    public function addCart(Request $request)
    {
        Session::forget('coupon_amount');
        Session::forget('coupon_code');

        $data = $request->all();

        if (empty($data['user_email'])) {
            $user_email = '';
        } else {
            $user_email = $data['user_email'];
        }

        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = str_random(40);
            Session::put('session_id', $session_id);
        }

        $size = explode('-', $data['size']);

        $count_products = DB::table('cart')->where(['product_id' => $data['product_id'], 'product_color' => $data['product_color'], 'size' => $size[1], 'session_id' => $session_id])->count();
        if ($count_products > 0) {
            return redirect()->back()->with('flash_message_error', 'Product already exists in Cart');
        }

        $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $size[1]])->first();

        DB::table('cart')->insert(['product_id' => $data['product_id'], 'product_name' => $data['product_name'], 'product_code' => $getSKU->sku, 'product_color' => $data['product_color'], 'price' => $data['price'], 'size' => $size[1], 'quantity' => $data['quantity'], 'user_email' => $user_email, 'session_id' => $session_id]);

        return redirect('cart')->with('flash_message_success', 'Product has been added in Cart');
    }

    public function showCart()
    {
        $session_id = Session::get('session_id');
        $user_cart = DB::table('cart')->where(['session_id' => $session_id])->get();
        foreach ($user_cart as $key => $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $user_cart[$key]->image = $productDetails->image;
        }

        return view('cart.cart')->with(compact('user_cart'));
    }

    public function deleteCartProduct($id = null)
    {
        Session::forget('coupon_amount');
        Session::forget('coupon_code');

        DB::table('cart')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Product has been deleted from Cart');
    }

    public function updateCartQuantity($id = null, $quantity = null)
    {
        Session::forget('coupon_amount');
        Session::forget('coupon_code');
        
        $getCartDetails = DB::table('cart')->where('id', $id)->first();
        $getStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        $updateQuantity = $getCartDetails->quantity + $quantity;
        if ($updateQuantity > $getStock->stock) {
            return redirect('cart')->with('flash_message_error', 'Required Product Quantity is not available');
        }

        DB::table('cart')->where('id', $id)->increment('quantity', $quantity);

        return redirect('cart')->with('flash_message_success', 'Product Quantity has been updated successfully');
    }

    public function applyCoupon(Request $request)
    {
        Session::forget('coupon_amount');
        Session::forget('coupon_code');

        $data = $request->all();
        $couponCount = Coupon::where('coupon_code', $data['coupon_code'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error', 'Coupon does not exists');
        } else {
            $couponDetails = Coupon::where('coupon_code', $data['coupon_code'])->first();

            if ($couponDetails->status == 0) {
                return redirect()->back()->with('flash_message_error', 'Coupon does not exists');
            }

            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if ($expiry_date < $current_date) {
                return redirect()->back()->with('flash_message_error', 'Coupon does not exists');
            }

            if ($couponDetails->amount_type == 'fixed') {
                $couponAmount = $couponDetails->amount;
            } else {
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
                $total_amount = 0;
                foreach ($userCart as $item) {
                    $total_amount += $item->price * $item->quantity;
                }
                $couponAmount = ($couponDetails->amount / 100) * $total_amount;

            }
            Session::put('coupon_amount', $couponAmount);
            Session::put('coupon_code', $data['coupon_code']);
            return redirect()->back()->with('flash_message_success', 'Coupon apply successfully');
        }
    }
}
