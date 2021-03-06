@extends('nqadmin-dashboard::backend.master')

@section('content')

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Quản lý nhân sự</h3>
                    <p>Công ty {{$company->name}} - MST {{$company->mst}}</p>

                    <form method="get" class="mt-2">
                        <ul class="nav nav-pills card-header-pills pull-left ml-0">
                            <li class="nav-item mr-2">
                                <div class="input-group">
                                    <input
                                            type="text"
                                            name="keyword"
                                            class="form-control"
                                            placeholder="Nhập SĐT, hoặc tên, CMND/CCCD"
                                            value="{{request()->get('keyword')}}"
                                            style="background-color: #fff"
                                    >
                                </div>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-sm btn-primary" style="height: 36px"><i class="fa fa-search"></i> <span class="text">Tìm kiếm</span></button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <form method="post" autocomplete="off">

                @if (count($errors) > 0)
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <strong>Lỗi!</strong> {{$e}}
                        </div>
                    @endforeach
                @endif

                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}
                {!! \Base\Supports\FlashMessage::renderMessage('create') !!}

                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Danh sách nhân sự</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="#">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkall" name="checkall">
                                            </div>
                                        </th>
                                        <th width="50">STT</th>
                                        <th width="200">Họ và tên</th>
                                        <th width="200">CMND/CCCD</th>
                                        <th width="150">Số điện thoại</th>
                                        <th width="100">Giới tính</th>
                                        <th width="150">Tuổi</th>
                                        <th width="100">Quản lý bởi </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $i = $employer->perPage() * ($employer->currentPage() - 1) + 1
                                    @endphp

                                    @foreach($employer as $e)
                                        <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox" value="{{$e->id}}" name="employers[]"/>
                                                </div>
                                            </td>
                                            <td class="text-center">{{$i++}}</td>
                                            <td>{{ $e->first_name }} {{$e->last_name}}</td>
                                            <td>{{ $e->citizen_identification }}</td>
                                            <td>{{ $e->phone }}</td>
                                            <td>{{ $e->sex }}</td>
                                            <td>
                                                <p>Ngày sinh {{$e->dob != null ? $e->dob->format('d/m/Y') : 'Chưa khai báo'}}</p>
                                                <p>Tuổi: {{ $e->old }}</p>
                                            </td>
                                            <td>
                                                @if ($e->getManager != null)
                                                    {{$e->getManager->first_name}} {{$e->getManager->last_name}}
                                                @else
                                                    Không có
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                                <div class="row">
                                    <div class="container ">
                                        <nav aria-label="..." class="align-self-center">
                                            @include('nqadmin-dashboard::backend.components.pagination',['paginator'=>$employer])
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card sticky-card">
                            <div class="card-header">
                                <h5 class="card-title">Thao tác</h5>
                            </div>
                            <div class="card-body">
                                <select name="action" id="action-list" class="form-control">
                                    <option value="transfer">Chuyển quyền quản lý</option>
                                    <option value="fire">Sa thải</option>
                                    <option value="up">Thăng cấp</option>
                                </select>
                                <input type="hidden" name="manager" value="" id="managerId">
                                <table class="table table-bordered table-hover mt-3 manager-list">
                                    <tbody>
                                    @foreach($manager as $m)
                                        <tr>
                                            <td style="cursor: pointer" class="select-manager" data-id="{{$m->id}}">
                                                {{$m->first_name}} {{$m->last_name}} -
                                                @if ($m->hard_role == 3)
                                                    Chủ doanh nghiệp
                                                @else
                                                    Quản lý
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Thực hiện</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .select-manager.active {
            background-color: #0a6aa1;
            color: #fff
        }

        .sticky-card {
	        position: sticky;
	        position: -webkit-sticky;
	        position: sticky;
	        top: 120px;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript">
	    $(document).ready(function () {
	    	$('body').on('click', '.select-manager', function () {
	    		$('.select-manager').removeClass('active')
                $(this).addClass('active')
	    		let value = $(this).attr('data-id');
	    		$('#managerId').val(value);
            })

		    $("#checkall").click(function(){
			    $('input[name="employers[]"]').prop('checked', this.checked);
		    });

	    	$('#action-list').click(function () {
	    		let value = $(this).val();
	    		if (value != 'transfer') {
	    			$('.manager-list').hide();
                }
            })
        })
    </script>
@endpush
