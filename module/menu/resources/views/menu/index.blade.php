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
    @endphp

    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Menu</h3>
                    <p>Danh sách vị trí menu trong hệ thống</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-16">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Menu
                                {{--@if ($permissions->contains('name','user_create'))--}}
                                    {{--<a href="{{route('nqadmin::users.create.get')}}" class="btn btn-primary pull-right">--}}
                                        {{--<i class="fa fa-plus" aria-hidden="true"></i> Add new menu position--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error!</strong> {{$e}}
                                    </div>
                                @endforeach
                            @endif
                            {!! \Base\Supports\FlashMessage::renderMessage('create') !!}
                            {!! \Base\Supports\FlashMessage::renderMessage('delete') !!}
                            <table class="table" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="10">No.</th>
                                    <th>Tên</th>
                                    <th>Vị trí</th>
                                    <th width="100">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $d)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{$d->position}}</td>
                                        <td class="center">
                                            @if ($permissions->contains('name','menu_edit'))
                                                <a href="{{route('nqadmin::menu.edit.get', ['id' => $d->id])}}" class=" btn btn-link btn-sm "><i class="fa fa-edit"></i></a>
                                            @endif

                                            {{--@if (Auth::id() != $d->id && $permissions->contains('name','user_delete'))--}}
                                                {{--<a href="" class="btn btn-link btn-sm" data-toggle="confirmation" data-url="{{route('nqadmin::users.delete.get', $d->id)}}">--}}
                                                    {{--<i class="fa fa-trash-o "></i>--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
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