@extends('nqadmin-dashboard::backend.master')

@section('js')
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/bootstrap-maxlength.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment-with-locales.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js-init')
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
	<script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/init.js')}}"></script>
@endsection

@section('css')
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
	<link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Gi??</h3>
					<p>S???a t???ng gi?? {{$data->name}}</p>
				</div>
			</div>
			
			<form method="post">
				@if (count($errors) > 0)
					@foreach($errors->all() as $e)
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
							<strong>L???i!</strong> {{$e}}
						</div>
					@endforeach
				@endif
				
				{!! \Base\Supports\FlashMessage::renderMessage('edit') !!}
				{!! \Base\Supports\FlashMessage::renderMessage('create') !!}
				{{csrf_field()}}
				
				<input type="hidden" value="{{Auth::id()}}" name="editor">
				<input type="hidden" value="{{$data->id}}" name="current_id">
				
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">S???a gi??
									<a href="{{route('nqadmin::pricetier.index.get')}}" class="btn btn-primary pull-right">
										<i class="fa fa-list-ol" aria-hidden="true"></i> Danh s??ch t???ng gi??
									</a>
								</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">T??n t???ng gi??</label>
									<input type="text"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="name"
									       value="{{$data->name}}"
									>
								</div>
								
								<div class="form-group">
									<label class="form-control-label">Gi??</label>
									<input type="number"
									       required
									       parsley-trigger="change"
									       class="form-control"
									       autocomplete="off"
									       name="price"
									       value="{{$data->price}}"
									>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Th??ng tin</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label class="form-control-label">Ng??y kh???i t???o: </label><br>
									<em><b>{{$data->created_at}}</b></em>
								</div>
								<div class="form-group">
									<label class="form-control-label">Kh???i t???o b???i: </label><br>
									<em><b>{{$data->owner->email}}</b></em>
								</div>
								<div class="form-group">
									<label class="form-control-label">L???n s???a cu???i: </label><br>
									<em><b>{{$data->updated_at}}</b></em>
								</div>
								<div class="form-group">
									<label class="form-control-label">Ng?????i s???a cu???i: </label><br>
									<em><b>{{(!empty($data->edit)) ? $data->edit->email : ''}}</b></em>
								</div>
							</div>
						</div>
						
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Thao t??c</h5>
							</div>
							<div class="card-body">
								<select class="custom-select form-control" name="status">
									<option value="active" {{ ($data->status == 'active') ? 'selected' : '' }}>K??ch ho???t</option>
									<option value="disable" {{ ($data->status == 'disable') ? 'selected' : '' }}>L??u nh??p</option>
								</select>
								<div class="form-group">
									<button type="submit" class="btn btn-primary" style="margin-top: 20px">L??u l???i</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection