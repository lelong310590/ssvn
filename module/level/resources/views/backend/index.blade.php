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
					<h3><i class="fa fa-sitemap "></i> Trình độ</h3>
					<p>Danh sách trình độ</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-5">
					<form method="post" action="{{route('nqadmin::level.create.post')}}">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Thêm trình độ mới</h5>
							</div>
							{{csrf_field()}}
							
							<input type="hidden" value="{{Auth::id()}}" name="author">
							<input type="hidden" value="category" name="type">
							<input type="hidden" value="{{\Carbon\Carbon::now()}}" name="published_at">
							
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Tên trình độ</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="name"
									       value="{{old('name')}}"
									       id="input_name"
									       onkeyup="ChangeToSlug();"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Slug</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="slug"
									       value="{{old('slug')}}"
									       id="input_slug"
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
								
								<div class="form-group">
									<label class="form-control-label">Hiện ngoài trang chủ</label>
									<select class="custom-select form-control" name="featured">
										<option value="disable" {{ (old('status') == 'disable') ? 'selected' : '' }}>Tắt</option>
										<option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Bật</option>
									</select>
								</div>
							</div>
						</div>
						
						@include('nqadmin-dashboard::backend.components.thumbnail')
						
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">SEO</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Seo title</label>
									<small class="form-text text-muted">Seo title nên dưới 80 ký tự</small>
									<input type="text"
									       class="form-control input-max-length"
									       autocomplete="off"
									       name="seo_title"
									       value="{{old('seo_title')}}"
									       id="input-seo-title"
									       maxlength="80"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Seo keyword</label>
									<small class="form-text text-muted">Mỗi từ khóa cách nhau bởi dấu ,. Tối đa 5 từ khóa </small>
									<input type="text"
									       class="form-control input-seo-keyword"
									       autocomplete="off"
									       name="seo_keywords"
									       value="{{old('seo_keywords')}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Seo description</label>
									<small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
									<textarea class="form-control input-max-length"
									          rows="3"
									          name="seo_description"
									          value="{{old('seo_description')}}"
									          maxlength="160"
									>
								</textarea>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary float-right">Lưu lại</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-sm-11">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Danh sách chuyên mục</h5>
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
									<th>Tên công ty</th>
									<th>Slug</th>
									{{--<th>Chuyên mục cha</th>--}}
									<th>Hiện trang chủ</th>
									<th width="100">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								@php
									$currentUser = Auth::user();
									$editable = $currentUser->can('level_edit');
									$deleteable = $currentUser->can('level_delete');
								@endphp
								@foreach($data as $d)
									<tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
										<td>{{ $d->name }}</td>
										<td class="center">{{ $d->slug }}</td>
										{{--<td class="center">{{$d->parent}}</td>--}}
										<td class="text-center">
											<a href="{{route('nqadmin::level.setFeatured.get', ['id' => $d->id])}}" style="color: {{($d->featured == 'active') ? 'gold' : '#ccc'}}">
												<i class="fa fa-star"></i>
											</a>
										</td>
										<td class="center">
											<a href="{{route('nqadmin::level.edit.get', ['id' => $d->id])}}"
											   class=" btn btn-link btn-sm ">
												<i class="fa fa-edit"></i>
											</a>

											<a href="javascript:;"
											   class="btn btn-link btn-sm"
											   data-toggle="confirmation"
											   data-url="{{route('nqadmin::level.delete.get', $d->id)}}">
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