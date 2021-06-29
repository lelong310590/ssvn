@extends('nqadmin-dashboard::backend.master')

@section('content')
	
	<div class="wrapper-content">
		<div class="container">
			<div class="row  align-items-center justify-content-between">
				<div class="col-11 col-sm-12 page-title">
					<h3><i class="fa fa-sitemap "></i> Quyền</h3>
					<p>Danh sách quyền có trong hệ thống</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-16">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Danh sách quyền</h5>
						</div>
						<div class="card-body">
							<p>Dánh sách các quyền tương ứng với từng <b>Module</b> có trong hệ thống</p>
							<div class="table-responsive">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th width="10">#ID</th>
											<th>Tên quyền</th>
											<th>Miêu tả</th>
											<th>Module</th>
										</tr>
									</thead>
									<tbody>
										@foreach($data as $d)
											<tr>
												<td>{{$d->id}}</td>
												<td>{{$d->name}}</td>
												<td>{{$d->description}}</td>
												<td><b>{{$d->module}}</b></td>
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
	</div>
	
@endsection