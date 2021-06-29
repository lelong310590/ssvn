@extends('nqadmin-dashboard::backend.master')

@push('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/ckeditor/ckeditor.js')}}"></script>
@endpush

@section('content')

<div class="wrapper-content">
    <div class="container">
        <div class="row  align-items-center justify-content-between">
            <div class="col-11 col-sm-12 page-title">
                <h3><i class="fa fa-sitemap "></i> Bài viết</h3>
                <p>Thêm bài viết mới</p>
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thêm bài viết mới
                                <a href="{{route('nqadmin::post.index.get')}}" class="btn btn-primary pull-right">
                                    <i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách bài viết
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
                                <textarea class="form-control ckeditor"
                                          name="content"
                                          required
                                          parsley-trigger="change"
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
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
                                <button class="btn btn-secondary"
                                        type="submit"
                                        name="continue_edit" value="1"
                                        style="margin-top: 20px"
                                >
                                    Lưu và chỉnh sửa
                                </button>
                            </div>
                        </div>
                    </div>

                    @include('nqadmin-dashboard::backend.components.thumbnail')
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
