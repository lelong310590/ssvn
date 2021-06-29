@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
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
                    <p>Sửa chuyên mục Chính sách bảo mật</p>
                </div>
            </div>

            <form method="post">
                {{ method_field('post') }}
                {{csrf_field()}}


                <input type="hidden" value="{{ $data->id }}" name="id">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sửa chuyên mục</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Tên chuyên mục</label>
                                    <input type="text" required="" parsley-trigger="change" class="form-control" autocomplete="off" name="name" value="{{ $data->name }}" id="input_name" onkeyup="ChangeToSlug();" data-parsley-id="4">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Slug</label>
                                    <input type="text" required="" parsley-trigger="change" class="form-control" autocomplete="off" name="slug" value="{{ $data->slug }}" id="input_slug" data-parsley-id="6">
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
                                    <input type="text" class="form-control input-max-length" autocomplete="off" name="seo_title" value="{{ $data->seo_title }}" id="input-seo-title" maxlength="80" data-parsley-id="8">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo keyword</label>
                                    <small class="form-text text-muted">Mỗi từ khóa cách nhau bởi dấu ,. Tối đa 5 từ khóa </small>
                                    <input type="text" placeholder="" value="{{ $data->seo_keywords }}" id="tags" name="seo_keywords">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description</label>
                                    <small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
                                    <textarea class="form-control input-max-length" rows="3" name="seo_description" value="" maxlength="160" data-parsley-id="14">
                                    {{ $data->seo_description }}
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
                                    <em><b>{{ $data->created_at }}</b></em>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Lần sửa cuối: </label><br>
                                    <em><b>{{ $data->updated_at }}</b></em>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Chuyên mục cha</label>
                                    <select class="form-control" name="parent" data-parsley-id="18">
                                        <option value="0">(Danh mục cha)</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ $data->parent==$parent->id?'selected':'' }}>{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thao tác</h5>
                            </div>
                            <div class="card-body">
                                <select class="form-control" name="status" data-parsley-id="20">
                                    <option value="active" {{ $data->status=='active'?'selected':'' }}>Kích hoạt</option>
                                    <option value="disable" {{ $data->status=='disable'?'selected':'' }}>Chưa kích hoạt</option>
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