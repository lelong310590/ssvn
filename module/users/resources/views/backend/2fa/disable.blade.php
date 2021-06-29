@extends('nqadmin-dashboard::backend.master')

@section('content')
	
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Tài khoản</h3>
					<p>Tắt xác minh 2 lớp</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Tắt xác minh 2 lớp</h5>
						</div>
						<div class="card-body">
							<form method="post" action="{{route('nqadmin::2fa.disable.post')}}">
								{{csrf_field()}}
								@if ($errors->has('totp'))
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
									<strong>Lỗi!</strong> Mã xác thực không đúng
								</div>
								@endif
								Để tắt xác minh 2 lớp, bạn hãy nhập lại mã xác thực một lần nữa
								<input type="hidden" name="user_id" value="{{Request::get('id')}}">
								<br />
								<div class="form-group">
									<label for="exampleInputEmail1">Mã xác thực</label>
									<div class="col-sm-4" style="padding: 0">
										<input type="text" class="form-control" placeholder="Nhập mã xác thực" name="totp">
									</div>
									<small id="emailHelp" class="form-text text-muted">Khi gỡ bỏ xác minh 2 lớp, bạn hãy gỡ bỏ phần xác minh này trong ứng dụng Google Authenticator</small>
								</div>
								<br />
								<button class="btn btn-primary" type="submit"><i class="fa fa-unlock" aria-hidden="true"></i> Tắt xác minh 2 lớp</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Mã kích hoạt xác minh 2 lớp cũ</h5>
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