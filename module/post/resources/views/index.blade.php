@extends('nqadmin-dashboard::backend.master')

@section('js')
    @include('nqadmin-dashboard::backend.components.datatables.source')
@endsection

@section('js-init')
    @include('nqadmin-dashboard::backend.components.datatables.init')
@endsection

@section('content')

    @php
        $user = Auth::user();
        $roles = $user->load('roles.perms');
        $permissions = $roles->roles->first()->perms;
        $type = Request::get('type');
    @endphp

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}</h3>
                    <p>Danh sách {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-16">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}
                                @if ($permissions->contains('name','post_create'))
                                    <a href="{{route('nqadmin::post.create.get', ['type' => $type])}}" class="btn btn-primary pull-right">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Add new {{$type == 'post' ? 'Bài viết' : 'Trang tĩnh'}}
                                    </a>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error !</strong> {{$e}}
                                    </div>
                                @endforeach
                            @endif
                            {!! \Base\Supports\FlashMessage::renderMessage('create') !!}
                            {!! \Base\Supports\FlashMessage::renderMessage('delete') !!}
                            <table class="table" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="10">#ID</th>
                                    @if ($type == 'post')
                                    <th width="80">Ảnh đại diện</th>
                                    @endif
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Ngày khởi tạo</th>
                                    <th width="100">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td>{{$d->id}}</td>
                                        @if ($type == 'post')
                                        <td>
                                            @if (!empty($d->thumbnail))
                                                <img src="{{ asset($d->thumbnail) }}" alt="{{ $d->email }}" class="img-fluid">
                                            @else
                                                <img src="{{ asset('adminux/img/advertise_maxartkiller_ui-ux.png') }}" alt="{{ $d->email }}" class="img-fluid">
                                            @endif
                                        </td>
                                        @endif
                                        <td>{{$d->name}}</td>
                                        <td class="center">{{ $d->getAuthor->email }}</td>
                                        <td class="center">
                                            {!! conver_status($d->status) !!}
                                        </td>
                                        <td class="center">
                                            @if ($permissions->contains('name','post_edit'))
                                                <a href="{{route('nqadmin::post.edit.get', ['id' => $d->id, 'type' => $type])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>
                                            @endif

                                            @if ($permissions->contains('name','post_delete'))
                                                <a href="javascript:;" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::post.delete.get', $d->id)}}">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection