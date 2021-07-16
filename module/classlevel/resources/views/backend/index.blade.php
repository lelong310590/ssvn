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
                    <h3><i class="fa fa-sitemap "></i> Công ty</h3>
                    <p>Danh sách Công ty</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-5">
                    <form method="post" action="{{route('nqadmin::classlevel.create.post')}}">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thêm Công ty mới</h5>
                            </div>
                            {{csrf_field()}}

                            <input type="hidden" value="{{Auth::id()}}" name="author">
                            <input type="hidden" value="category" name="type">
                            <input type="hidden" value="{{\Carbon\Carbon::now()}}" name="published_at">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Tên Công ty <span class="text-danger">*</span></label>
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

                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Mã số thuế <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   required
                                                   parsley-trigger="change"
                                                   class="form-control"
                                                   autocomplete="off"
                                                   name="mst"
                                                   value="{{old('mst')}}"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   required
                                                   parsley-trigger="change"
                                                   class="form-control"
                                                   autocomplete="off"
                                                   name="phone"
                                                   value="{{old('phone')}}"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                    <select name="province" id="provinces-id" class="form-control" required>
                                        <option value="">-- Chọn Tỉnh / Thành phố</option>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->id}}">{{$province->province_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Quận / Huyện <span class="text-danger">*</span></label>
                                    <select name="district" id="district-id" class="form-control" required></select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Phường / Xã <span class="text-danger">*</span></label>
                                    <select name="ward" id="ward-id" class="form-control" required></select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text"
                                           required
                                           parsley-trigger="change"
                                           class="form-control"
                                           autocomplete="off"
                                           name="address"
                                           value="{{old('address')}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Email liên hệ <span class="text-danger">*</span></label>
                                    <input type="email"
                                           required
                                           parsley-trigger="change"
                                           class="form-control"
                                           autocomplete="off"
                                           name="email"
                                           value="{{old('email')}}"
                                    >
                                </div>

                                <input type="hidden" name="parent" value="0">

{{--                                <div class="form-group">--}}
{{--                                    <label class="form-control-label">Thuộc khối</label>--}}
{{--                                    <select class="custom-select form-control" name="group">--}}
{{--                                        <option value="primary" {{ (old('group') == 'primary') ? 'selected' : '' }}>Tiểu học</option>--}}
{{--                                        <option value="secondary" {{ (old('group') == 'secondary') ? 'selected' : '' }}>Trung học cơ sở</option>--}}
{{--                                        <option value="high" {{ (old('group') == 'high') ? 'selected' : '' }}>Trung học phổ thông</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}

                                <div class="form-group">
                                    <label class="form-control-label">Trạng thái</label>
                                    <select class="custom-select form-control" name="status">
                                        <option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Kích hoạt</option>
                                        <option value="disable" {{ (old('status') == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
                                    </select>
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
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thông tin người đại diện</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">CCCD/CMND <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           value="{{old('citizen_identification')}}"
                                           name="citizen_identification"
                                           required
                                    >
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Họ <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   required
                                                   data-parsley-pattern="[a-zA-Z0-9\s]+"
                                                   name="first_name"
                                                   value="{{old('first_name')}}"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Tên và tên đệm <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   required
                                                   data-parsley-pattern="[a-zA-Z0-9\s]+"
                                                   name="last_name"
                                                   value="{{old('last_name')}}"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="example-date-input" class="form-control-label">Ngày/Tháng/Năm sinh <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" value="{{old('dob')}}" name="dob" id="example-date-input" max="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <label class="form-control-label">Giới tính</label>
                                        <select class="custom-select form-control" name="sex">
                                            <option value="male" {{ (old('sex') == 'male') ? 'selected' : '' }}>Nam</option>
                                            <option value="female" {{ (old('sex') == 'female') ? 'selected' : '' }}>Nữ</option>
                                            <option value="other" {{ (old('sex') == 'other') ? 'selected' : '' }}>Khác</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thêm Công ty mới</h5>
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
                                    <small class="form-text text-muted">Mỗi từ khóa cách nhau bởi dấu ,. Tối đa 5 từ khóa</small>
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
                            <h5 class="card-title">Danh sách các Công ty</h5>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Lỗi!</strong> {{$e}}
                                    </div>
                                @endforeach
                            @endif
                            {!! \Base\Supports\FlashMessage::renderMessage('create') !!}
                            {!! \Base\Supports\FlashMessage::renderMessage('delete') !!}
                            <table class="table" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Tên Công ty</th>
                                    <th width="150">MST</th>
                                    <th width="100">Trạng thái</th>
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
                                        <td class="center">{{ $d->mst }}</td>
{{--                                        <td class="center">{{$d->group}}</td>--}}
                                        <td>
                                            <a href="{{route('nqadmin::classlevel.changeStatus.get', ['id' => $d->id])}}">
                                                {!! conver_status($d->status) !!}
                                            </a>
                                        </td>
                                        <td class="center">
                                            <a href="{{route('nqadmin::classlevel.edit.get', ['id' => $d->id])}}"
                                               class=" btn btn-link btn-sm ">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="javascript:;"
                                               class="btn btn-link btn-sm"
                                               data-toggle="confirmation"
                                               data-url="{{route('nqadmin::classlevel.delete.get', $d->id)}}">
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

@push('js')
    <script type="text/javascript">
	    jQuery(document).ready(function ($) {
	    	const provinceSelect = $('#provinces-id');
	    	const districtSelect = $('#district-id');
	    	const wardSelect = $('#ward-id');
	    	const body = $('body');

		    body.on('change', '#provinces-id', function () {
			    $.ajax({
				    url: '{{route('ajax.get-districts')}}',
				    type: 'GET',
				    data: {
					    provinceId: $(this).val(),
                    },
				    success: function( response ) {
					    districtSelect.html(response.html);
					    wardSelect.empty();
				    },
				    error: function( err ) {

				    }
			    });
            })

		    body.on('change', '#district-id', function () {
			    $.ajax({
				    url: '{{route('ajax.get-wards')}}',
				    type: 'GET',
				    data: {
					    districtId: $(this).val(),
				    },
				    success: function( response ) {
					    wardSelect.html(response.html);
				    },
				    error: function( err ) {

				    }
			    });
		    })
        })
    </script>
@endpush