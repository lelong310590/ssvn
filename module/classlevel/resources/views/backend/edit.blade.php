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
                    <h3><i class="fa fa-sitemap "></i> C??ng ty</h3>
                    <p>S???a {{$data->name}}</p>
                </div>
            </div>

            @if (count($errors) > 0)
                @foreach($errors->all() as $e)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>L???i!</strong> {{$e}}
                    </div>
                @endforeach
            @endif

            {!! \Base\Supports\FlashMessage::renderMessage('import-success') !!}

            <div class="card">
                <div class="card-header">
                    Nh???p d??? li???u nh??n s???
                </div>
                <div class="card-body">
                    <form action="{{route('nqadmin::classlevel.import')}}" method="post" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="hidden" name="classlevel" value="{{$data->id}}">
                                    <input
                                            type="file"
                                            class="form-control"
                                            name="excel_file"
                                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    >
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <select class="form-control" style="height: 42px" name="manager">
                                        <option value="">-- Ch???n ng?????i ph??? tr??ch --</option>
                                        @foreach($owner as $o)
                                            <option value="{{$o->id}}">{{$o->first_name}} - {{$o->last_name}} | CMND/CCCD: {{$o->citizen_identification}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <button type="submit" class="btn btn-primary" style="min-height: 41.5px">Nh???p d??? li???u</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <form method="post">

                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}
                {!! \Base\Supports\FlashMessage::renderMessage('create') !!}
                {{csrf_field()}}

                <input type="hidden" value="{{Auth::id()}}" name="editor">
                <input type="hidden" value="{{$data->id}}" name="current_id">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">S???a c??ng ty
                                    <a href="{{route('nqadmin::classlevel.index.get')}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-list-ol" aria-hidden="true"></i> Danh s??ch C??ng ty
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">T??n c??ng ty</label>
                                    <input type="text"
                                           required
                                           parsley-trigger="change"
                                           class="form-control"
                                           autocomplete="off"
                                           name="name"
                                           value="{{$data->name}}"
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
                                           value="{{$data->slug}}"
                                           id="input_slug"
                                    >
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-control-label">M?? s??? thu??? <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   required
                                                   parsley-trigger="change"
                                                   class="form-control"
                                                   autocomplete="off"
                                                   name="mst"
                                                   value="{{$data->mst}}"
                                            >
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label class="form-control-label">Ng?????i ?????i ??i???n ph??p lu???t <span class="text-danger">*</span></label>--}}
{{--                                    <select name="ward" id="ward-id" class="form-control" required>--}}
{{--                                        <option value=""> -- Ch???n ng?????i ?????i di???n --</option>--}}
{{--                                        @foreach($owner as $o)--}}
{{--                                            <option value="{{$o->id}}" {{$o->citizen_identification == $data->owner_cid ? 'selected' : ''}}>--}}
{{--                                                {{$o->first_name}} {{ $o->last_name  }} - CCCD/CMND: {{ $o->citizen_identification }}--}}
{{--                                            </option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}

                                <div class="alert alert-info">
                                    <p><b>?????a ch???: </b></p>
                                    <p>{{$data->fulladdress}}</p>
                                </div>
                                <div class="form-group has-success">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               name="change_address"
                                               id="change-address-button"
                                               {{old('change_address') != null ? 'checked' : ''}}
                                        >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">
                                            S???a ?????a ch???
                                        </span>
                                    </label>
                                </div>

                                <div id="change-address" style="display: none">
                                    <div class="form-group">
                                        <label class="form-control-label">T???nh / Th??nh ph??? <span class="text-danger">*</span></label>
                                        <select name="province" id="provinces-id" class="form-control">
                                            <option value="">-- Ch???n T???nh / Th??nh ph???</option>
                                            @foreach($provinces as $province)
                                                <option value="{{$province->id}}" {{$data->province == $province->id ? 'selected' : ''}}>{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Qu???n / Huy???n <span class="text-danger">*</span></label>
                                        <select name="district" id="district-id" class="form-control"></select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Ph?????ng / X?? <span class="text-danger">*</span></label>
                                        <select name="ward" id="ward-id" class="form-control"></select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">?????a ch??? <span class="text-danger">*</span></label>
                                        <input type="text"
                                               parsley-trigger="change"
                                               class="form-control"
                                               autocomplete="off"
                                               name="address"
                                               value="{{$data->address}}"
                                        >
                                    </div>
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
                                    <small class="form-text text-muted">Seo title n??n d?????i 80 k?? t???</small>
                                    <input type="text"
                                           class="form-control input-max-length"
                                           autocomplete="off"
                                           name="seo_title"
                                           value="{{$data->seo_title}}"
                                           id="input-seo-title"
                                           maxlength="80"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo keyword</label>
                                    <small class="form-text text-muted">M???i t??? kh??a c??ch nhau b???i d???u ,. T???i ??a 5 t??? kh??a</small>
                                    <input type="text"
                                           class="form-control input-seo-keyword"
                                           autocomplete="off"
                                           name="seo_keywords"
                                           value="{{$data->seo_keywords}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description</label>
                                    <small class="form-text text-muted">Seo description n??n d?????i 160 k?? t???</small>
                                    <textarea class="form-control input-max-length"
                                              rows="3"
                                              name="seo_description"
                                              maxlength="160"
                                    >
										{{$data->seo_description}}
								</textarea>
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
                                <div class="form-group">
                                    <label class="form-control-label">Th???i gian xu???t b???n:</label>
                                    <div class='input-group date' id='datetimepicker'>
                                        <input
                                                type='text'
                                                class="form-control"
                                                name="published_at"
                                                value="{{(old('published_at')) ? old('published_at') : date('d/m/Y H:i', strtotime($data->published_at))}}"
                                        />
                                        <span class="input-group-addon">
				                            <span class="fa fa-calendar"></span>
										</span>
                                    </div>
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

            body.on('click', '#change-address-button', function () {
	            if($(this).is(":checked")){
		            $('#change-address').show();
	            }
	            else if($(this).is(":not(:checked)")){
		            $('#change-address').hide();
	            }
            });
		})
    </script>
@endpush