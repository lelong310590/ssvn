@extends('nqadmin-dashboard::backend.master')

@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
@endsection

@section('js-init')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endsection

@section('content')
    @php
        $user = Auth::user();
        $roles = $user->load('roles.perms');
        $permissions = $roles->roles->first()->perms;
    @endphp

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Menu Node</h3>
                    <p>Sửa Menu Node</p>
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

                <input type="hidden" name="menu" value="{{$node->menu}}">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Sửa Menu Node
                                    <a href="{{route('nqadmin::menu.edit.get', ['id' => $node->menu])}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-list-ol" aria-hidden="true"></i> Danh sách các Node
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Kiểu node</label>
                                    <select name="type" class="form-control">
                                        <option value="custom" {{$node->type == 'custom' ? 'selected' : ''}}>Url tủy chỉnh</option>
                                        <option value="page" {{$node->type == 'page' ? 'selected' : ''}}>Trang tĩnh</option>
                                    </select>
                                </div>

                                <div class="form-group node-page">
                                    <label class="form-control-label">Chọn trang tĩnh</label>
                                    @php
                                        $url = $node->url;
                                        $segment = explode('/', $url);
                                        $lastSegment = end($segment);
                                    @endphp
                                    <select name="pagenode" class="form-control select2">
                                        <option value="">-- Chọn trang tĩnh --</option>
                                        @foreach($pages as $page)
                                            <option value="{{$page->slug}}" {{$page->slug == $lastSegment ? 'selected' : ''}}>{{$page->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group node-name">
                                    <label class="form-control-label">Tiêu đề Node</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           name="name"
                                           value="{{$node->name}}"
                                    >
                                </div>

                                <div class="form-group node-url">
                                    <label class="form-control-label">Node Url</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           name="url"
                                           value="{{$node->url}}"
                                           @if ($node->type != 'custom')
                                               readonly
                                           @endif
                                    >
                                </div>

                                <div class="form-group node-index">
                                    <label class="form-control-label">Thứ tự Node</label>
                                    <input type="number"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           name="index"
                                           value="{{$node->index}}"
                                    >
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
    <script type="text/javascript">
        var nodeType = $('select[name="type"]');
        var nodePage = $('.node-page');

        nodeType.on('change', function (e) {
            var _this = $(e.currentTarget);
            var value = _this.val();
            if (value == 'page') {
                nodePage.show();
                $('input[name="url"]').attr('readonly', true)
            } else {
                nodePage.hide();
                $('input[name="url"]').removeAttr('readonly')
                $('input[name="url"]').val('');
                $('input[name="name"]').val('');
            }
        })

        $('select[name="pagenode"]').on('select2:select', function (e) {
            var data = e.params.data;
            var name = data.text;
            var url = 'page/' + data.id;

            $('input[name="name"]').val(name);
            $('input[name="url"]').val(url);
        });

    </script>
@endpush