@extends('nqadmin-dashboard::backend.master')

@section('js')
	@include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
	@include('nqadmin-dashboard::backend.components.datatables.init')
@endsection

@section('content')

<div class="wrapper-content">
	<div class="container">
		<div class="row  align-items-center justify-content-between">
			<div class="col-11 col-sm-12 page-title">
				<h3><i class="fa fa-sitemap "></i> Khóa đào tạo</h3>
				<p>Danh sách đào tạo</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-16">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Danh sách đào tạo
							<a href="{{route('nqadmin::course.create.get')}}" class="btn btn-primary pull-right">
								<i class="fa fa-plus" aria-hidden="true"></i> Thêm đào tạo
							</a>
						</h5>
					</div>
					<div class="card-header">
						<form method="get">
							<h6 class="card-title pull-left">Tìm kiếm</h6>
							<ul class="nav nav-pills card-header-pills pull-left ml-2">

								<li class="nav-item ml-2">
									<div class="input-group">
										<input type="text" name="name" class="form-control" aria-label="" placeholder="Tên đào tạo">
									</div>
								</li>

								<li class="nav-item">
									<button class="btn btn-sm btn-primary "><i class="fa fa-search"></i> <span class="text">Tìm kiếm</span></button>
								</li>
								<li class="ml-3"><span class="btn btn-info"> <a style="color:#fff" href="{{route('nqadmin::course.index.get')}}">Làm lại</a> </span></li>
							</ul>

						</form>
					</div>
					<div class="card-body">
						@if (count($errors) > 0)
							@foreach($errors->all() as $e)
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
									<strong>Lỗi!</strong> {{$e}}
								</div>
							@endforeach
						@endif

						{!! \Base\Supports\FlashMessage::renderMessage('create') !!}
						{!! \Base\Supports\FlashMessage::renderMessage('delete') !!}

						<table class="table table-bordered" id="#">
							<thead>
							<tr>
								<th width="100">Ảnh đào tạo</th>
								<th width="300">Thông tin đào tạo</th>
								<th width="130">Loại đào tạo</th>
								<th width="130">Trạng thái</th>
								<th width="150">Ngày khởi tạo</th>
								<th width="150">Lần cập nhật cuối</th>
								<th width="120">Thao tác</th>
							</tr>
							</thead>
							<tbody>
							@php
								$currentUser = Auth::user();
								$editable = $currentUser->can('course_edit');
								$deleteable = $currentUser->can('course_delete');
							@endphp
							@foreach($data as $d)
								<tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
									<td>
										@if (!empty($d->getLdp))
											@if (!empty($d->getLdp->thumbnail))
												<img src="{{ asset($d->getLdp->thumbnail) }}" alt="{{ $d->email }}" width="100" height="100">
											@else
												<img src="{{ asset('adminux/img/placeholder.png') }}" alt="{{ $d->email }}">
											@endif
										@else
											<img src="{{ asset('adminux/img/placeholder.png') }}" alt="{{ $d->email }}">
										@endif
									</td>
									<td>
										<h5>{{$d->name}}</h5>
									</td>
									<td>
										@if($d->type =='test')
											<span class="status primary"><i class="fa fa-question"></i> Trắc nghiệm</span>
										@elseif ($d->type == 'exam')
											<span class="status info"><i class="ti-agenda"></i> Thi thử</span>
										@else
											<span class="status warning"><i class="fa fa-file-video-o"></i> Cơ bản</span>
										@endif
									</td>
									<td>
										@if($d->status=='active')
											<span class="status success">Đã duyệt</span>
										@else
											<span class="status danger">Chưa duyệt</span>
										@endif
									</td>
									<td>
										{{$d->created_at}}
									</td>
									<td>
										{{$d->updated_at}}
									</td>
									<td class="center">
										<a href="{{route('nqadmin::course.curriculum.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>

										<a href="" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::course.delete.get', $d->id)}}">
											<i class="fa fa-trash-o "></i>
										</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						<!-- /.table-responsive -->
							<div class="row">
								<div class="container ">
									<nav aria-label="..." class="align-self-center">
										@include('nqadmin-dashboard::backend.components.pagination',['paginator'=>$data])
									</nav>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection