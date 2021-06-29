@extends('nqadmin-dashboard::backend.master')

@section('content')
	
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
					<p>Xác minh 2 lớp</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Xác minh 2 lớp</h5>
						</div>
						<div class="card-body">
							Mở ứng dụng Google Authenticator trên điện thoại của bạn và scan mã QR sau
							<br />
							<img alt="Image of QR barcode" src="{{ $image }}" />
							
							<br />
							Nếu điện thoại của bạn không hỗ trợ đọc mã QR thì hãy nhập mã sau vào: <code>{{ $secret }}</code>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection