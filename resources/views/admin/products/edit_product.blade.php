@extends('layouts.adminLayout.admin_design')

@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Edit Product</a> </div>
            <h1>Products</h1>
        </div>
        <div class="container-fluid"><hr>
            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif

            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Edit Product</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{ url('/admin/edit-product/'.$productDetails->id) }}" name="edit_product" id="edit_product" novalidate="novalidate" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="control-group">
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <select name="category_id" id="category_id" style="width: 220px;">
                                            <?php echo $categories_dropdown; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Name</label>
                                    <div class="controls">
                                        <input type="text" name="name" id="name" value="{{ $productDetails->product_name }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Code</label>
                                    <div class="controls">
                                        <input type="text" name="code" id="code" value="{{ $productDetails->product_code }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Color</label>
                                    <div class="controls">
                                        <input type="text" name="color" id="color" value="{{ $productDetails->product_color }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="description" id="description">{{ $productDetails->description }}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Material & Care</label>
                                    <div class="controls">
                                        <textarea name="care" id="care">{{ $productDetails->care }}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                        <input type="text" name="price" id="price" value="{{ $productDetails->price }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image</label>
                                    <div class="controls">
                                        <input type="file" name="image" id="image">
                                        <input type="hidden" name="current_image" value="{{ $productDetails->image }}">
                                        @if(!empty($productDetails->image))
                                            <img src="{{ asset('images/backend_images/products/small/'.$productDetails->image) }}" alt="{{ $productDetails->image }}" style="width: 50px;"> |
                                            <a href="{{ url('/admin/delete-product-image/'.$productDetails->id) }}">Delete</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Enable</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status" value="1" @if($productDetails->status == 1) checked @endif>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="Edit Product" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
