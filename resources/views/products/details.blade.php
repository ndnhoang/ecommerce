@extends('layouts.frontLayout.front_design')

@section('content')
    <section>
        <div class="container">
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
            <div class="row">
                <div class="col-sm-3">
                    @include('layouts.frontLayout.front_sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                    <a href="{{ asset('images/backend_images/products/large/'.$productDetails->image) }}">
                                        <img id="main-image" src="{{ asset('images/backend_images/products/medium/'.$productDetails->image) }}" alt="" style="width: 300px;" />
                                    </a>
                                </div>
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                        <a href="{{ asset('images/backend_images/products/large/'.$productDetails->image) }}" class="change-image" data-standard="{{ asset('images/backend_images/products/medium/'.$productDetails->image) }}"><img src="{{ asset('images/backend_images/products/small/'.$productDetails->image) }}" alt="" style="width: 80px;"></a>
                                        @foreach($productImages as $image)
                                            <a href="{{ asset('images/backend_images/products/large/'.$image->image) }}" class="change-image" data-standard="{{ asset('images/backend_images/products/medium/'.$image->image) }}"><img src="{{ asset('images/backend_images/products/small/'.$image->image) }}" alt="" style="width: 80px;"></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-7">
                            <form name="add_to_cart" id="add_to_cart" action="{{ url('add-cart') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                                <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                                <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                                <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">
                                <div class="product-information"><!--/product-information-->
                                <img src="{{ url('images/frontend_images/product-details/new.jpg') }}" class="newarrival" alt="" />
                                <h2>{{ $productDetails->product_name }}</h2>
                                <p>Code: {{ $productDetails->product_code }}</p>
                                <p>
                                    <select name="size" id="size" style="width: 150px;">
                                        <option value="">Select</option>
                                        @foreach($productDetails->attributes as $attribute)
                                            <option value="{{ $productDetails->id."-".$attribute->size }}">{{ $attribute->size }}</option>
                                        @endforeach
                                    </select>
                                </p>
                                <img src="{{ asset('images/frontend_images/product-details/rating.png') }}" alt="" />
                                <span>
									<span id="get_price">${{ $productDetails->price }}</span>
									<label>Quantity:</label>
									<input type="text" name="quantity" value="3" />
                                    @if($total_stock > 0)
                                        <button type="submit" class="btn btn-fefault cart" id="cart_button">
                                            <i class="fa fa-shopping-cart"></i>
                                            Add to cart
                                        </button>
                                    @endif
								</span>
                                <p><b>Availability:</b> <span id="status_stock">@if($total_stock > 0)In Stock @else Out of Stock @endif </span></p>
                                <p><b>Condition:</b> New</p>
                                <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                            </div><!--/product-information-->
                            </form>
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#care" data-toggle="tab">Material & Care</a></li>
                                <li><a href="#delivery" data-toggle="tab">Delivery</a></li>
                            </ul>
                        </div>
                        <div class="tab-content col-sm-12">
                            <div class="tab-pane fade active in" id="description" >
                                {{ $productDetails->description }}
                            </div>

                            <div class="tab-pane fade" id="care" >
                                {{ $productDetails->care }}
                            </div>

                            <div class="tab-pane fade" id="delivery" >
                                <p>100% Original Products <br>
                                Cash on delivery</p>
                            </div>

                        </div>
                    </div><!--/category-tab-->

                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>

                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php $count = 0; ?>
                                @foreach($relatedProducts->chunk(3) as $chunk) <?php $count++; ?>
                                    <div class="item @if($count == 1) active @endif">
                                        @foreach($chunk as $item)
                                            <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <img src="{{ asset('images/backend_images/products/medium/'.$item->image) }}" alt="" style="width: 160px;" />
                                                        <h2>${{ $item->price }}</h2>
                                                        <p>{{ $item->product_name }}</p>
                                                        <a href="{{ url('product/'.$item->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div><!--/recommended_items-->

                </div>
            </div>
        </div>
    </section>
@endsection
