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
                    <h3><i class="fa fa-sitemap "></i> {{$type == 'post' ? 'Post' : 'Page'}}</h3>
                    <p>Create new {{$type == 'post' ? 'post' : 'page'}}</p>
                </div>
            </div>

            <form method="post">
                @if (count($errors) > 0)
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <strong>Error!</strong> {{$e}}
                        </div>
                    @endforeach
                @endif

                {{csrf_field()}}
                <input type="hidden" value="{{Auth::id()}}" name="author">
                <input type="hidden" value="{{$type}}" name="post_type">
                <input type="hidden" value="{{$post->id}}" name="current_id">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Edit {{$type == 'post' ? 'post' : 'page'}}
                                    <a href="{{route('nqadmin::post.index.get', ['type' => $type])}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-list-ol" aria-hidden="true"></i> List {{$type == 'post' ? 'post' : 'page'}}
                                    </a>

                                    <a href="{{route('nqadmin::post.create.get', ['type' => $type])}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add new post
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">

                                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}

                                <div class="form-group">
                                    <label class="form-control-label">Title</label>
                                    <input type="text"
                                           required
                                           parsley-trigger="change"
                                           class="form-control"
                                           autocomplete="off"
                                           name="name"
                                           value="{{$post->name}}"
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
                                           value="{{$post->slug}}"
                                           id="input_slug"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Content</label>
                                    <textarea id="ckeditor"
                                              class="form-control"
                                              name="content"
                                              required
                                              parsley-trigger="change"
                                    >{{$post->content}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Excerpt</label>
                                    <textarea class="form-control"
                                              rows="3"
                                              name="excerpt"
                                              value="{{old('excerpt')}}"
                                    >{{$post->excerpt}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Thứ tự (Ưu tiên từ thấp đến cao)</label>
                                    <input type="number"
                                           class="form-control"
                                           autocomplete="off"
                                           name="order"
                                           value="{{$post->order}}"
                                    >
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
                                           value="{{$post->seo_title}}"
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
                                           value="{{$post->seo_keywords}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description</label>
                                    <small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
                                    <textarea class="form-control input-max-length"
                                              rows="3"
                                              name="seo_description"
                                              value="{{$post->seo_description}}"
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
                                        <option value="active" {{ ($post->status == 'active') ? 'selected' : '' }}>Kích hoạt</option>
                                        <option value="disable" {{ ($post->status == 'disable') ? 'selected' : '' }}>Lưu nháp</option>
                                    </select>
                                </div>

                                @if ($type == 'page')
                                    <div class="form-group">
                                        <label class="form-control-label">Giao diện trang tĩnh</label>
                                        <select class="custom-select form-control" name="template">
                                            <option value="page" {{ ($post->template == 'page') ? 'selected' : '' }}>Mặc định</option>
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
                                </div>
                            </div>
                        </div>

{{--                        @include('nqadmin-dashboard::components.thumbnail', ['data' => $post])--}}
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection