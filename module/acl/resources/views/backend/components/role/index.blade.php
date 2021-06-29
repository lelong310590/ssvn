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
					<h3><i class="fa fa-sitemap "></i> Vai trò</h3>
					<p>Danh sách vai trò</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Danh sách vai trò
								<a href="{{route('nqadmin::role.create.get')}}" class="btn btn-primary pull-right">
									<i class="fa fa-plus" aria-hidden="true"></i> Thêm vai trò
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
							<table class="table " id="dataTables-example">
								<thead>
									<tr>
										<th width="10">STT</th>
										<th>Tên vai trò</th>
										<th>Slug</th>
										<th>Miêu tả</th>
										<th width="100">Thao tác</th>
									</tr>
								</thead>
								<tbody>
									@php
										$currentUser = Auth::user();
									@endphp
									@foreach($data as $d)
										<tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
											<td>{{$loop->index + 1}}</td>
											<td>{{ $d->display_name }}</td>
											<td>{{ $d->name }}</td>
											<td>{{ $d->description }}</td>
											<td class="center">
												@if ($currentUser->can('role_edit'))
												<a href="{{route('nqadmin::role.edit.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>
												@endif
												
												@if ($currentUser->roles()->first()->id != $d->id && $currentUser->can('role_delete'))
													<a href="" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::role.delete.delete', $d->id)}}">
														<i class="fa fa-trash-o "></i>
													</a>
												@endif
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