@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection
@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
@endsection
@extends('nqadmin-dashboard::backend.master')
@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Chuyên mục</h3>
                    <p>Danh sách chuyên mục</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-5">
                    <form method="post" action="" novalidate="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thêm chuyên mục mới</h5>
                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" value="1" name="author">
                            <input type="hidden" value="category" name="type">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Tên chuyên mục</label>
                                    <input type="text" required="" parsley-trigger="change" class="form-control"
                                           autocomplete="off" name="name" value="" id="input_name"
                                           onkeyup="ChangeToSlug();" data-parsley-id="4">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Slug</label>
                                    <input type="text" required="" parsley-trigger="change" class="form-control"
                                           autocomplete="off" name="slug" value="" id="input_slug" data-parsley-id="6">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Chuyên mục cha</label>
                                    <select class="form-control" name="parent" data-parsley-id="18">
                                        <option value="0">(Danh mục cha)</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <option value="active">Kích hoạt</option>
                                        <option value="disable">Lưu nháp</option>
                                    </select>
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
                                    <input type="text" class="form-control input-max-length" autocomplete="off"
                                           name="seo_title" value="" id="input-seo-title" maxlength="80"
                                           data-parsley-id="12">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo keyword</label>
                                    <small class="form-text text-muted">Mỗi từ khóa cách nhau bởi dấu ,. Tối đa 5 từ
                                        khóa
                                    </small>
                                    <input type="text" placeholder="" name="seo_keywords" id="tags">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description</label>
                                    <small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
                                    <textarea class="form-control input-max-length" rows="3" name="seo_description"
                                              value="" maxlength="160"
                                              data-parsley-id="18">								</textarea>
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
                            <h5 class="card-title">Danh sách chuyên mục</h5>
                        </div>
                        <div class="card-body">


                                <div class="row">
                                    <div class="col-md-16">
                                        <table class="table dataTable no-footer" id="dataTables-example">
                                            <thead>
                                            <tr role="row">
                                                <th>Tên chuyên mục</th>
                                                <th>Chuyên mục cha</th>
                                                <th>Slug</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $category)
                                                <tr>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->parent!=0?$category->getParentName():'' }}</td>
                                                    <td>{{ $category->slug }}</td>
                                                    <td>
                                                        @if($category->status=='active')
                                                            <a href="{{ route('nqadmin::get.changestatuscategory',['id' => $category->id]) }}">
                                                                <span class="status success">Kích hoạt</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('nqadmin::get.changestatuscategory',['id' => $category->id]) }}">
                                                                <span class="status danger">Chưa kích hoạt</span>
                                                            </a>
                                                        @endif

                                                    </td>
                                                    <td class="center">
                                                            <a href="{{route('nqadmin::get.editcategory', ['id' => $category->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>

                                                            <a href="" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::post.deletecategory', $category->id)}}">
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
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{asset('adminux/js/typeahead.js')}}"></script>
    <script>
        var citynames = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{ route("nqadmin::course.tags.get") }}',
                filter: function (list) {
                    return $.map(list, function (cityname) {
                        return {name: cityname};
                    });
                }
            }
        });
        citynames.initialize();

        $('#tags').tagsinput({
            // typeaheadjs: {
            //     name: 'citynames',
            //     displayKey: 'name',
            //     valueKey: 'name',
            //     source: citynames.ttAdapter(),
            // },
            // confirmKeys: [13, 188]
        });

        $('.bootstrap-tagsinput').on('keypress', function (e) {
            if (e.keyCode == 13) {
                e.keyCode = 188;
                e.preventDefault();
            }
            ;
        });

    </script>
@endpush