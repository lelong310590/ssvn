@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
@endsection

@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
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
                    <h3><i class="fa fa-sitemap "></i> Sửa Menu</h3>
                    <p>Sửa menu trong vùng Menu</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-5">
                    <form method="post" action="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thêm node menu</h5>
                            </div>
                            {{csrf_field()}}

                            <input type="hidden" value="{{$menu->id}}" name="menu">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Kiểu Node</label>
                                    <select name="type" class="form-control">
                                        <option value="custom">Url tủy chỉnh</option>
                                        <option value="page">Trang tĩnh</option>
                                    </select>
                                </div>

                                <div class="form-group node-page">
                                    <label class="form-control-label">Chọn trang tĩnh</label>
                                    <select name="pagenode" class="form-control select2">
                                        <option value="">-- Chọn trang tĩnh --</option>
                                        @foreach($pages as $page)
                                            <option value="{{$page->slug}}">{{$page->name}}</option>
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
                                           value="{{old('name')}}"
                                    >
                                </div>

                                <div class="form-group node-url">
                                    <label class="form-control-label">Url Node</label>
                                    <input type="text"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           name="url"
                                           value="{{old('url')}}"
                                    >
                                </div>

                                <div class="form-group node-index">
                                    <label class="form-control-label">Thứ tự Node</label>
                                    <input type="number"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           name="index"
                                           value="{{old('index')}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Thêm node</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-11">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh sách các node trong {{$menu->name}}</h5>
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

                            <div class="menu-list">
                                <ul class="menu-wrapper">
                                    @foreach($nodes as $node)
                                        <li class="menu-item">
                                            <div class="menu-item-wrapper">
                                                <div class="menu-item-name">
                                                    Tiêu đề: <b>{{$node->name}}</b>
                                                </div>
                                                <div class="menu-item-slug">
                                                    @if ($node->type == 'custom')
                                                        Url: <b>{{$node->url}}</b>
                                                    @else
                                                        Url: <b>{{env('APP_URL').$node->url}}</b>
                                                    @endif
                                                </div>
                                                <div class="menu-item-index">
                                                    <span>Thứ tự: <b>{{$node->index}}</b></span>

                                                    <a href="{{route('nqadmin::menu-node.edit.get', ['id' => $node->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>

                                                    @if ($permissions->contains('name','menu_delete'))
                                                    <a href="javascript:;" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::menu.delete.get', $node->id)}}">
                                                        <i class="fa fa-trash-o "></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style type="text/css">
        .node-page, .node-rank-services {display: none;}
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        var nodeType = $('select[name="type"]');
        var nodePage = $('.node-page');
        var nodeRS = $('.node-rank-services');


        nodeType.on('change', function (e) {
            var _this = $(e.currentTarget);
            var value = _this.val();
            if (value == 'page') {
                nodePage.show();
                $('input[name="url"]').attr('readonly', true)
            } else if (value == 'rank_service') {
                nodeRS.show();
                nodePage.hide();
                $('input[name="url"]').attr('readonly', true)
            } else {
                nodePage.hide();
                nodeRS.hide();
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

        $('select[name="rsnode"]').on('select2:select', function (e) {
            var data = e.params.data;
            var name = data.text;
            var url = 'rank-service/' + data.id;

            $('input[name="name"]').val(name);
            $('input[name="url"]').val(url);
        });

    </script>
@endpush