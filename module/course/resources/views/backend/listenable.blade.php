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
					<p>Duyệt Khóa đào tạo</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Danh sách Khóa đào tạo
								<a href="{{route('nqadmin::course.enable.all')}}" class="btn btn-primary pull-right">
									 Duyệt tất cả
								</a>
							</h5>
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
							<table class="table" id="dataTables">
								<thead>
								<tr>
									<th width="100">Ảnh Khóa đào tạo</th>
									<th>Thông tin Khóa đào tạo</th>
									<th>Thao tác</th>
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
										<td class="center">
											@if($d->status=='active')
												<a class="btn btn-success" href="{{ route('nqadmin::course.enable.post',['id'=>$d->id]) }}">Đã duyệt</a>
											@else
												<a class="btn btn-danger" href="{{ route('nqadmin::course.enable.post',['id'=>$d->id]) }}">Chưa duyệt</a>
											@endif
												<a class="btn btn-info" href="{{ route('nqadmin::course.curriculum.get',['id'=>$d->id]) }}">Xem trước</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
							<!-- /.table-responsive -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection