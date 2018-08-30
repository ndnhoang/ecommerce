<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

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
            $product->price = $data['price'];

//            upload image
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
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
            $product->save();
            return redirect('/admin/view-products')->with('flash_message_success', 'Product has been added successfully');
        }

        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>Select</option>";
        foreach ($categories as $category) {
            $categories_dropdown .= "<option value='".$category->id."'>".$category->name."</option>";
            $sub_categories = Category::where(['parent_id' => $category->id])->get();
            foreach ($sub_categories as $sub_category) {
                $categories_dropdown .= "<option value='".$sub_category->id."'>&nbsp;--&nbsp;".$sub_category->name."</option>";
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

            $filename = $data['current_image'];
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
//                    Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                }
            }

            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => $data['name'], 'product_code' => $data['code'], 'product_color' => $data['color'], 'description' => $description, 'price' => $data['price'], 'image' => $filename]);
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
            $categories_dropdown .= "<option value='".$category->id."' ".$selected.">".$category->name."</option>";
            $sub_categories = Category::where(['parent_id' => $category->id])->get();
            foreach ($sub_categories as $sub_category) {
                if ($sub_category->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='".$sub_category->id."' ".$selected.">&nbsp;--&nbsp;".$sub_category->name."</option>";
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
        if (file_exists($large_image_path.$productImage)) {
            unlink($large_image_path.$productImage);
        }
        if (file_exists($medium_image_path.$productImage)) {
            unlink($medium_image_path.$productImage);
        }
        if (file_exists($small_image_path.$productImage)) {
            unlink($small_image_path.$productImage);
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
                     $attribute = new ProductsAttribute();
                     $attribute->product_id = $id;
                     $attribute->sku = $value;
                     $attribute->size = $data['size'][$key];
                     $attribute->price = $data['price'][$key];
                     $attribute->stock = $data['stock'][$key];
                     $attribute->save();
                }
            }
            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been added successfully');
        }

        return view('admin.products.add_attributes')->with(compact('productDetails'));
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
            $products = Product::whereIn('category_id', $category_ids)->get();
        } else {
//            if url is sub category url
            $products = Product::where(['category_id' => $id])->get();
        }

        return view('products.listing')->with(compact('categoryDetails', 'products', 'categories'));
    }

    public function showProductDetails($id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();


        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        return view('products.details')->with(compact('productDetails', 'categories'));
    }

    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        $productArr = explode("-", $data['size']);
        $productArr = ProductsAttribute::where(['product_id' => $productArr[0], 'size' => $productArr[1]])->first();
        echo $productArr->price;
    }
}
