<!-- Start Footer Area -->
<footer class="footer">
    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <!-- Single Widget -->
                    @php
                    $settings=DB::table('settings')->get();
                    @endphp
                    <div class="single-footer about">
                        <div class="logo">
                            <a href=""><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"></a>
                        </div>
                        <p class="text">@foreach($settings as $data) {{$data->short_des}} @endforeach</p>
                        <p class="call">Điện thoại 24/7<span><a href="tel:0902880088">@foreach($settings as $data) {{$data->phone}} @endforeach</a></span></p>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer links">
                        <h4>Thông tin </h4>
                        <ul>
                            <li><a href="#">Sản phẩm</a></li>
                            <li><a href="#">Khuyến mãi</a></li>
                            <li><a href="#">Tin tức</a></li>
                            <li><a href="">Liên hệ</a></li>
                            <li><a href="#">Trợ giúp</a></li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <!-- Single widget -->
                    <div class="single-footer links">
                        <h4> Khách hàng</h4>
                        <ul>
                            <li><a href="#">Thanh toán</a></li>
                            <li><a href="#"> Hoàn tiền</a></li>
                            <li><a href="#">Trả hàng</a></li>
                            <li><a href="#">Vận chuyển</a></li>
                            <li><a href="#">Chính sách</a></li>
                        </ul>
                    </div>
                    <!-- End Single widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer social">
                        <h4>Liên lạc</h4>
                        <!-- Single Widget -->
                        <div class="contact">
                            <ul>
                            </ul>
                        </div>
                        <li>@foreach($settings as $data) {{$data->address}} @endforeach</li>
                        <li>@foreach($settings as $data) {{$data->email}} @endforeach</li>
                        <li>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
                        <!-- End Single Widget -->
                        <div class="sharethis-inline-follow-buttons"></div>
                    </div>
                    <!-- End Single widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>Copyright © {{date('Y')}} <a href="https://chosi.net" target="_blank">www.chosi.net</a> Đã đăng ký Bản quyền</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="right">
                            │<img src="{{asset('backend/img/payments.png')}}" alt="#">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /End Footer Area -->