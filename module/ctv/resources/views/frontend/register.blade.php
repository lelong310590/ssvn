@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="box-banner-teacher">
            <div class="container">
                <div class="main-search">
                    <h3 class="txt-title text-center">
                        <span>safecovid </span>
                        Ra đời với sứ mệnh truyền đạt kiến thức thuộc mọi lĩnh vực đến với tất cả mọi người
                    </h3>
                    <div class="content">
                        <p class="txt text-center">Kiến thức của bạn sẽ tạo ra những giá trị đích thực khi nó được chia sẻ. Với Edumall, chúng tôi cùng bạn tạo ra một hành trình truyền cảm hứng đơn giản nhất để giúp bạn lantỏa tri thức, tạo ra những giá trị đích thực trong bất cứ lĩnh vực nào mà bạn tự tin. Chúngtôi tin rằng, vì "tri thức là sức mạnh", mọi người sẽ không ngừng tiến bộ và xã hội sẽ không ngừng trở nên tốt đẹp hơn.</p>
                        <div class="box-btn text-center">
                            <a href="{{(Auth::check()) ? route('nqadmin::post.registerctv') : '#login-box'}}" class="btn btn-default-yellow btn-small btn-popup">Trở thành cộng tác viên của chúng tôi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--box-banner-teacher-->

        <div class="box-cooperative">
            <div class="container">
                <div class="text-center">
                    <h3 class="txt-title-teacher">Tại sao nên hợp tác cùng safecovid</h3>
                </div>
                <div class="main-cooperative row">
                    <div class="col-xs-4">
                        <div class="list-cooperative">
                            <div class="images text-center">
                                <span class="border-images"><i class="far fa-lightbulb"></i></span>
                            </div>
                            <div class="content">
                                <h4 class="txt">Dạy đam mê</h4>
                                <p class="">Chia sẻ kiến thức - công việc của bạn không những tạo ra những giá trị tốt đẹp cho cuộc sống mà còn làm cuộc sống của chính bạn trở nên ý nghĩa. Vì vậy chúng tôi hiểu rằng, để bạn làm công việc đó thật tốt mỗi ngày, những gì bạn nói, bạn chia sẻ, truyền đạt phải là những gì bạn thật sự yêu thích và tin tưởng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="list-cooperative">
                            <div class="images text-center">
                                <span class="border-images"><i class="far fa-handshake"></i></span>
                            </div>
                            <div class="content">
                                <h4 class="txt">Truyền cảm hứng</h4>
                                <p class="">Với nền tảng E-learning của Edumall, bạn sẽ có thể lan tỏa tri thức tới hàng triệu học viên trên khắp mọi miền Tổ quốc. Và nhờ đó, mỗi lần trao tri thức chính là một lần bạn trao đi nguồn cảm hứng, đem đến sự khác biệt và cùng Edumall thực hiện sứ mệnh Triệu người nâng Trí tuệ.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="list-cooperative">
                            <div class="images text-center">
                                <span class="border-images"><i class="far fa-gem"></i></span>
                            </div>
                            <div class="content">
                                <h4 class="txt">Nhận lại những gì bạn xứng đáng</h4>
                                <p class="">Mọi bài học và tri thức bạn chia sẻ đều xuất phát từ chính nỗ lực của bạn. Nhờ đó, bạn sẽ không chỉ nhận được thu nhập thụ đồng hàng tháng lên đến 8 chữ số, mà còn có thể quảng bá thưuơng hiệu cá nhân rộng rãi và mở rộng Network với hằng trăm giảng viên, chuyên gia thuộc rất nhiều lĩnh vực khác nhau</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--box-cooperative-->

        <div class="box-slide box-story">
            <div class="container">
                <h2 class="txt-title text-center">Những câu chuyện thành công</h2>
                <div class=" owl-carousel-1">
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-30.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Thầy Nguyễn Đức Việt</a> </h4>
                                <p class="note">Giảng viên Thiết kế web tại FPT - Arena</p>
                                <p>“Phụ trách giảng dạy bộ môn Thiết kế web tại FPT - Arena đã được 7 năm nhưng tôi thực sự ấn tượng với công nghệ giáo dục trực tuyến ở đây. Các công cụ hỗ trợ chuẩn hóa giáo trình đã truyền cảm hứng cho tôi “giảng dạy công nghệ bằng chính công nghệ”, nâng cao chất lượng bài giảng của mình.”</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-31.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Thầy Hiển Râu</a> </h4>
                                <p class="note">Giảng viên Thiết kế web tại FPT - Arena</p>
                                <p>"Sau gần 1 năm đồng hành cùng Edumall, càng làm việc nhiều tôi càng hài lòng với những gì mình cho đi và nhận được. Các nhân viên Edumall thực sự đã giúp đỡ tôi rất nhiều trong việc nâng cao chất lượng bài giảng cũng như chia sẻ những bài học guitar bài bản đến hàng nghìn học viên không có điều kiện tham gia học guitar trực tiếp."</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-32.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Th.S Nguyễn Danh Tú</a> </h4>
                                <p class="note">Nhà sáng lập BKINDEX GROUP</p>
                                <p>"Mục đích của tôi từ ngày đầu đi dạy đến giờ vẫn luôn là chia sẻ càng nhiều càng tốt, với nhiều người nhất có thể. Tuy nhiên, dù cố gắng thế nào, tôi cũng không thể tiếp cận được với hàng nghìn người ở khắp mọi vùng miền để chia sẻ kiến thức. Và Edumall đã trở thành cầu nối giúp tôi thực hiện mong ước bấy lâu nay"</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-30.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Thầy Nguyễn Đức Việt</a> </h4>
                                <p class="note">Giảng viên Thiết kế web tại FPT - Arena</p>
                                <p>“Phụ trách giảng dạy bộ môn Thiết kế web tại FPT - Arena đã được 7 năm nhưng tôi thực sự ấn tượng với công nghệ giáo dục trực tuyến ở đây. Các công cụ hỗ trợ chuẩn hóa giáo trình đã truyền cảm hứng cho tôi “giảng dạy công nghệ bằng chính công nghệ”, nâng cao chất lượng bài giảng của mình.”</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-31.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Thầy Hiển Râu</a> </h4>
                                <p class="note">Giảng viên Thiết kế web tại FPT - Arena</p>
                                <p>"Sau gần 1 năm đồng hành cùng Edumall, càng làm việc nhiều tôi càng hài lòng với những gì mình cho đi và nhận được. Các nhân viên Edumall thực sự đã giúp đỡ tôi rất nhiều trong việc nâng cao chất lượng bài giảng cũng như chia sẻ những bài học guitar bài bản đến hàng nghìn học viên không có điều kiện tham gia học guitar trực tiếp."</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="main-story">
                            <div class="images">
                                <a href="#" class="">
                                    <img src="{{asset('frontend/images/img-32.png')}}" alt="" width="" height="">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="name"><a href="#">Th.S Nguyễn Danh Tú</a> </h4>
                                <p class="note">Nhà sáng lập BKINDEX GROUP</p>
                                <p>"Mục đích của tôi từ ngày đầu đi dạy đến giờ vẫn luôn là chia sẻ càng nhiều càng tốt, với nhiều người nhất có thể. Tuy nhiên, dù cố gắng thế nào, tôi cũng không thể tiếp cận được với hàng nghìn người ở khắp mọi vùng miền để chia sẻ kiến thức. Và Edumall đã trở thành cầu nối giúp tôi thực hiện mong ước bấy lâu nay"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--box-story-->

        <div class="box-journey">
            <div class="container">
                <div class="text-center">
                    <h2 class="txt-title-teacher">Đơn giản hóa hành trình truyền cảm hứng cùng safecovid</h2>
                </div>
                <div class="list-journey">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="images">
                                <img src="{{asset('frontend/images/img-33.png')}}" alt="" width="" height="">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="content">
                                <div class="list">
                                    <h4 class="txt">Đăng ký</h4>
                                    <p>Tất cả những gì bạn cần làm là để lại một số thông tin cơ bản, chúng tôi sẽ liên lạc với bạn trong vòng 3 ngày</p>
                                </div>
                                <div class="list">
                                    <h4 class="txt">Soạn đề cương</h4>
                                    <p>Dạy những gì bạn biết, chia sẻ những gì bạn đam mê. Xuất phát từ ý tưởng về một lĩnh vực bạn yêu thích, hãy tưởng tượng bạn sẽ dạy những gì và soạn bài dựa trên kinh nghiệm của mình</p>
                                </div>
                                <div class="list">
                                    <h4 class="txt">Quay video</h4>
                                    <p>Hãy thật tự nhiên, thoải mái chia sẻ kiến thức và là chính bản thân mình. Nếu bạn biết tự quay phim và dựng phim, đó sẽ là một lợi thế không nhỏ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-xs-push-6">
                            <div class="images">
                                <img src="{{asset('frontend/images/img-34.png')}}" alt="" width="" height="">
                            </div>
                        </div>
                        <div class="col-xs-6 col-xs-pull-6">
                            <div class="content">
                                <div class="list">
                                    <h4 class="txt">Xuất bản</h4>
                                    <p>Sau khi nội dung của bạn được xuất bản, chúc mừng bạn đã chia sẻ tri thức đến hàng triệu người ở bất cứ đâu, có thể truy cập được trên bất cứ thiết bị nào.</p>
                                </div>
                                <div class="list">
                                    <h4 class="txt">Thu nhập</h4>
                                    <p>Chia sẻ kiến thức, tạo ra những giá trị đích thực và nhận lại nguồn thu nhập trong mơ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--box-journey-->


    </div>
    <!--main-page-->

@endsection