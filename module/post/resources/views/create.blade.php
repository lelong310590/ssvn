@extends('nqadmin-dashboard::backend.master')

@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/bootstrap-maxlength.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/ckeditor4.8/ckeditor.js')}}"></script>
@endsection

@section('js-init')
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/init.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/init.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/ckeditor4.8/init.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
@endsection

@section('content')

@php
    $type = Request::get('type');
@endphp

<div class="wrapper-content">
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3><i class="fa fa-sitemap "></i> {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}</h3>
                <p>Tạo mới {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}</p>
            </div>
        </div>

        <form method="post">
            @if (count($errors) > 0)
                @foreach($errors->all() as $e)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        <strong>Lỗi!</strong> {{$e}}
                    </div>
                @endforeach
            @endif

            {{csrf_field()}}
            <input type="hidden" value="{{Auth::id()}}" name="author">
            <input type="hidden" value="{{Request::get('type')}}" name="post_type">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Create new {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}
                                <a href="{{route('nqadmin::post.index.get', ['type' => $type])}}" class="btn btn-primary pull-right">
                                    <i class="fa fa-list-ol" aria-hidden="true"></i> List {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label">Tiêu đề</label>
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
                                <label class="form-control-label">Nội dung</label>
                                <textarea id="ckeditor"
                                          class="form-control"
                                          name="content"
                                          required
                                          parsley-trigger="change"
                                ></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Miêu tả ngắn</label>
                                <textarea class="form-control"
                                          rows="3"
                                          name="excerpt"
                                          value="{{old('excerpt')}}"
                                ></textarea>
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
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thao tác</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label class="form-control-label">Trạng thái </label>
                                <select class="custom-select form-control" name="status">
                                    <option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="disable" {{ (old('status') == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
                                </select>
                            </div>

                            @if ($type == 'page')
                            <div class="form-group">
                                <label class="form-control-label">Giao diện trang tĩnh </label>
                                <select class="custom-select form-control" name="template">
                                    <option value="page" {{ (old('template') == 'page') ? 'selected' : '' }}>Mặc định</option>
                                </select>
                            </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>

                                <button class="btn btn-secondary"
                                        type="submit"
                                        name="continue_edit" value="1"
                                        style="margin-top: 20px"
                                >
                                    Lưu và tiếp tục
                                </button>
                            </div>
                        </div>
                    </div>

{{--                    @if ($type == 'post')--}}
{{--                    @include('nqadmin-dashboard::backend.components.thumbnail')--}}
{{--                    @endif--}}
                </div>
            </div>
        </form>
    </div>
</div>

@endsection