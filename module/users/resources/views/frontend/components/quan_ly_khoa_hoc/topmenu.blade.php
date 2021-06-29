<ul class="clearfix">
    <li class="pull-left"><a href="{{ route('front.users.tong_quan_khoa_hoc.get') }}" class="{{ strpos(url()->current(), route('front.users.tong_quan_khoa_hoc.get')) !== false?'active':'' }}">Khóa đào tạo</a></li>
    <li class="pull-left"><a href="{{ route('front.users.tong_quan_khoa_hoc_hoi_dap.get') }}" class="{{ strpos(url()->current(), route('front.users.tong_quan_khoa_hoc_hoi_dap.get')) !== false?'active':'' }}">Hỏi đáp Khóa đào tạo</a></li>
    <li class="pull-left"><a href="{{ route('front.users.tong_quan_khoa_hoc_danh_gia.get') }}" class="{{ strpos(url()->current(), route('front.users.tong_quan_khoa_hoc_danh_gia.get')) !== false?'active':'' }}">Đánh giá</a></li>
</ul>