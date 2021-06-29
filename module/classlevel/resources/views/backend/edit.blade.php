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
                    <h3><i class="fa fa-sitemap "></i> Công ty</h3>
                    <p>Sửa {{$data->name}}</p>
                </div>
            </div>

            <form method="post">
                @if (count($errors) > 0)
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Lỗi!</strong> {{$e}}
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
                                <h5 class="card-title">Sửa công ty
                                    <a href="{{route('nqadmin::classlevel.index.get')}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách Công ty
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Tên công ty</label>
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

{{--                                <div class="form-group">--}}
{{--                                    <label class="form-control-label">Thuộc khối</label>--}}
{{--                                    <select class="custom-select form-control" name="group">--}}
{{--                                        <option value="primary" {{ ($data->getOriginal('group') == 'primary') ? 'selected' : '' }}>Tiểu học</option>--}}
{{--                                        <option value="secondary" {{ ($data->getOriginal('group') == 'secondary') ? 'selected' : '' }}>Trung học cơ sở</option>--}}
{{--                                        <option value="high" {{ ($data->getOriginal('group') == 'high') ? 'selected' : '' }}>Trung học phổ thông</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
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
                                           value="{{$data->seo_title}}"
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
                                           value="{{$data->seo_keywords}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description</label>
                                    <small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
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
                                <h5 class="card-title">Thông tin</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Ngày khởi tạo: </label><br>
                                    <em><b>{{$data->created_at}}</b></em>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Khởi tạo bởi: </label><br>
                                    <em><b>{{$data->owner->email}}</b></em>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Lần sửa cuối: </label><br>
                                    <em><b>{{$data->updated_at}}</b></em>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Người sửa cuối: </label><br>
                                    <em><b>{{(!empty($data->edit)) ? $data->edit->email : ''}}</b></em>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Thời gian xuất bản:</label>
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
                                <h5 class="card-title">Thao tác</h5>
                            </div>
                            <div class="card-body">
                                <select class="custom-select form-control" name="status">
                                    <option value="active" {{ ($data->status == 'active') ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="disable" {{ ($data->status == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
                                </select>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection