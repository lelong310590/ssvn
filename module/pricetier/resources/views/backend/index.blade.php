@extends('nqadmin-dashboard::backend.master')

@section('js')
	@include('nqadmin-dashboard::backend.components.datatables.source')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/bootstrap-maxlength.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
@endsection

@section('js-init')
	@include('nqadmin-dashboard::backend.components.datatables.init')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/init.js')}}"></script>
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
@endsection

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Tầng giá</h3>
					<p>Danh sách giá</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-5">
					<form method="post" action="{{route('nqadmin::pricetier.create.post')}}">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Thêm giá mới</h5>
							</div>
							{{csrf_field()}}
							
							<input type="hidden" value="{{Auth::id()}}" name="author">
							<input type="hidden" value="category" name="type">
							<input type="hidden" value="{{\Carbon\Carbon::now()}}" name="published_at">
							
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Tên tầng giá</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="name"
									       value="{{old('name')}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Giá</label>
									<input type="number"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="price"
									       value="{{old('price')}}"
									>
								</div>
								
								<input type="hidden" name="parent" value="0">
								
								<div class="form-group">
									<label class="form-control-label">Trạng thái</label>
									<select class="custom-select form-control" name="status">
										<option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Kích hoạt</option>
										<option value="disable" {{ (old('status') == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
									</select>
								</div>
								
								<button type="submit" class="btn btn-primary float-left" style="margin-top: 15px">Lưu lại</button>
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-sm-11">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Danh sách các tầng giá</h5>
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
							<table class="table" id="dataTables-example">
								<thead>
								<tr>
									<th>Tên tầng giá</th>
									<th>Giá</th>
									{{--<th>Chuyên mục cha</th>--}}
									<th>Trạng thái</th>
									<th width="100">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								@php
									$currentUser = Auth::user();
									$editable = $currentUser->can('classlevel_edit');
									$deleteable = $currentUser->can('classlevel_delete');
								@endphp
								@foreach($data as $d)
									<tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
										<td>{{ $d->name }}</td>
										<td class="center">{{ number_format($d->price) }} đ</td>
										{{--<td class="center">{{$d->parent}}</td>--}}
										<td>
											<a href="{{route('nqadmin::pricetier.changeStatus.get', ['id' => $d->id])}}">
												{!! conver_status($d->status) !!}
											</a>
										</td>
										<td class="center">
											<a href="{{route('nqadmin::pricetier.edit.get', ['id' => $d->id])}}"
											   class=" btn btn-link btn-sm ">
												<i class="fa fa-edit"></i>
											</a>

											<a href="javascript:;"
											   class="btn btn-link btn-sm"
											   data-toggle="confirmation"
											   data-url="{{route('nqadmin::pricetier.delete.get', $d->id)}}">
												<i class="fa fa-trash-o "></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection