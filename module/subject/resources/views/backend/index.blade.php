@extends('nqadmin-dashboard::backend.master')

@section('js')
	@include('nqadmin-dashboard::backend.components.datatables.source')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
@endsection

@section('js-init')
	@include('nqadmin-dashboard::backend.components.datatables.init')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endsection

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Chứng chỉ</h3>
					<p>Danh sách Chứng chỉ</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-5">
					<form method="post" action="{{route('nqadmin::subject.create.post')}}">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Thêm Chứng chỉ mới</h5>
							</div>
							
							{{csrf_field()}}
							<input type="hidden" value="{{Auth::id()}}" name="author">
							
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Tên Chứng chỉ </label>
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
								
								<div class="form-group">
									<label class="form-control-label">Icon </label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="icon"
									       value="{{old('icon')}}"
									       data-toggle="modal"
									       data-target="#modal-icon"
									       readonly
									       style="cursor: pointer"
									       id="icon"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Chứng chỉ dành cho các công ty </label>
									<div class="form-group" style="height:150px; overflow-y: scroll; border: 1px solid #eee; padding: 10px">
										@foreach($classLevel as $class)
										<div class="col-xs-16">
											<label class="custom-control custom-checkbox">
											<input
												type="checkbox"
												class="custom-control-input"
												name="subject[]"
												value="{{$class->id}}"
											>
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description"> {{$class->name}}</span>
											</label>
										</div>
										@endforeach
									</div>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary float-right">Lưu lại</button>
								</div>
							</div>
						</div>
						
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
							<h5 class="card-title">Danh sách Chứng chỉ</h5>
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
									<th>Tên Chứng chỉ</th>
									<th>Icon</th>
									<th width="100">Thao tác</th>
								</tr>
								</thead>
								<tbody>
								@php
									$currentUser = Auth::user();
									$editable = $currentUser->can('subject_edit');
									$deleteable = $currentUser->can('subject_delete');
								@endphp
								@foreach($data as $d)
									<tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
										<td>{{ $d->name }}</td>
										<td><i class="{{$d->icon}}"></i></td>
										<td class="center">
											<a href="{{route('nqadmin::subject.edit.get', ['id' => $d->id])}}"
											   class=" btn btn-link btn-sm ">
												<i class="fa fa-edit"></i>
											</a>

											<a href="javascript:;"
											   class="btn btn-link btn-sm"
											   data-toggle="confirmation"
											   data-url="{{route('nqadmin::subject.delete.get', $d->id)}}">
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
	
	@include('nqadmin-dashboard::backend.components.icon')
@endsection