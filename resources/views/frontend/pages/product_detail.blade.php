@extends('frontend.layouts.master')
@section('main-content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">Chi Tiết Cửa Hàng</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
<section class="shop single section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <!-- Images slider -->
                            <div class="flexslider-thumbnails carousel slide" data-ride="carousel">
                                <div class="slides carousel-inner" style="width: 550px; height: 600px; object-fit: cover; margin-bottom: 5px">
                                    @php
                                    $photo=explode(',',$product_detail->photo);
                                    @endphp
                                    @foreach ($photo as $key=>$data)
                                    <div class="carousel-item {{(($key==0)? 'active' : '')}}" data-thumb="{{$data}}">
                                        <img src="{{$data}}" alt="{{$data}}">
                                    </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Trước</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Kế Tiếp</span>
                                </a>
                            </div>

                        </div>

                        <div class="" style="display: flex; justify-content: center">
                            @php
                            $photo=explode(',',$product_detail->photo);
                            @endphp
                            @foreach ($photo as $key=>$data)
                            <img src="{{$data}}" alt="{{$data}}" style="width: 170px; height: 180px; margin-right: 10px; display: inline-block; object-fit: cover; border-radius: 8px; border: 2px solid #3498db ">
                            @endforeach
                            </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="product-des">
                            <!-- Description -->
                            <div class="short">
                                <h4>{{$product_detail->title}}</h4>
                                <div class="rating-main">
                                    <ul class="rating">
                                        @php
                                        $rate=ceil($product_detail->getReview->avg("rate"))
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <li><i class="fa fa-star"></i></li>
                                            @else
                                            <li><i class="fa fa-star-o"></i></li>
                                            @endif
                                            @endfor
                                    </ul>
                                </div>
                                <a href="#" class="total-review">({{$product_detail['getReview']->count()}}) Đánh Giá</a>
                                @php
                                $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                @endphp
                                <p class=" price"><span class="discount">{{number_format($after_discount,2)}}đ</span><s>{{number_format($product_detail->price, 2)}}đ</s></p>
                                <p class="description">{!!($product_detail->summary)!!}</p>
                            </div>
                            <!-- Color -->
                            <div class="color">
                                <h4>Tùy chọn có sẵn Màu sắc <span>Màu</span></h4>
                                <ul>
                                    <li><a href="#" class="one"><i class="ti-check"></i></a></li>
                                    <li><a href="#" class="two"><i class="ti-check"></i></a></li>
                                    <li><a href="#" class="three"><i class="ti-check"></i></a></li>
                                    <li><a href="#" class="four"><i class="ti-check"></i></a></li>
                                </ul>
                            </div>
                            <!--/ End Color -->
                            <!-- Size -->
                            @if($product_detail->size)
                            <div class="size mt-4">
                                <h4>kích cỡ</h4>
                                <ul>
                                    @php
                                    $sizes=explode(',',$product_detail->size);
                                    @endphp
                                    @foreach($sizes as $size)
                                    <li><a href="#" class="one">{{$size}}</a></li>
                                    @endforeach
                                    </ul>
                            </div>
                            @endif

                            <div class="product-buy">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="quantity">
                                        <h6>Số lượng :</h6>
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                            <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1" id="quantity">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- End Input Order -->
                                    </div>
                                    <div class="add-to-cart mt-4">
                                        <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                                        <a href="" class="btn min"><i class="ti-heart"></i></a>
                                    </div>
                                </form>
                                <p class="cat">Loại : <a href="">{{$product_detail->cat_info['title']}}</a></p>
                                @if($product_detail->sub_cat_info)
                                <p class="cat mt-1">Danh mục phụ :<a href="">{{$product_detail->sub_cat_info['title']}}</a></p>
                                @endif
                                <p class="availability">Cổ phần: @if($product_detail->stock>0)
                                    <span class="badge badge-success">{{$product_detail->stock}}</span>
                                    @else
                                    I
                                    <span class="badge badge-danger">{{$product_detail->stock}}</span> @endif
                                </p>
                            </div>

                        </div>
                    </div>
</div>
</div>
        </div>
    </div>
    
</section>
@endsection