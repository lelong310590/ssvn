<?php
$route = \Request::route()->getName();
?>
<div class="menu-left">
    <h3 class="txt-title">Quản lý Khóa đào tạo</h3>
    <ul>
        <li><a href="{{ route('front.users.quan_ly_khoa_hoc_gia.get',['id'=>$id]) }}" <?php if($route=='front.users.quan_ly_khoa_hoc_gia.get'):?>class="active"<?php endif;?>>Giá và phiếu giảm giá</a> </li>
        <li><a href="{{ route('front.users.quan_ly_khoa_hoc_thong_bao.get',['id'=>$id]) }}" <?php if($route=='front.users.quan_ly_khoa_hoc_thong_bao.get'):?>class="active"<?php endif;?>>Thông báo</a> </li>
        <li><a href="{{ route('front.users.quan_ly_khoa_hoc_hoc_sinh.get',['id'=>$id]) }}" <?php if($route=='front.users.quan_ly_khoa_hoc_hoc_sinh.get'):?>class="active"<?php endif;?>>Học sinh</a> </li>
        <li><a href="{{ route('front.users.quan_ly_khoa_hoc_thong_ke.get',['id'=>$id]) }}" <?php if($route=='front.users.quan_ly_khoa_hoc_thong_ke.get'):?>class="active"<?php endif;?>>Thống kê</a> </li>
    </ul>
</div>