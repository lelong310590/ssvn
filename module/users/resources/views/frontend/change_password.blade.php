@extends('nqadmin-dashboard::frontend.master')

@section('content')

    <div class="main-page">
        <div class="page-user">
            <div class="container">
                <div class="row">
                    <div class="left-user col-xs-2">
                        @include('nqadmin-users::frontend.partials.sidebar')
                    </div>
                    <div class="right-user col-xs-10">
                        <div class="text-center title-page">
                            <h3 class="txt">Thay đổi mật khẩu</h3>
                        </div>
                        <form method="post" action="{{ route('front.users.change_password.post') }}" id="form-change-password">
                            {{ csrf_field() }}
                            <div class="box-change-password">
                                <div class="box-form-default">
                                    <div class="box-update-email">
                                        <h4 class="txt-title">Cập nhật thông tin Email</h4>
                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Email</label>
                                            <div class="form col-xs-9">
                                                <div class="change-email">
                                                    <input type="text" class="input-form" value="Địa chỉ email của bạn là {{ $data->email }}" readonly>
                                                    {{--<a href="#" class="btn btn-default-yellow">Sửa</a>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--box-update-information-->

                                    <div class="box-update-password">
                                        <h4 class="txt-title">Thay đổi mật khẩu</h4>
                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Mật khẩu</label>
                                            <div class="form col-xs-9">
                                                <input type="password" class="input-form" placeholder="Nhập mật khẩu" name="current-password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Mật khẩu mới</label>
                                            <div class="form col-xs-9">
                                                <input type="password" class="input-form" placeholder="Nhập mật khẩu mới" name="new-password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Nhập lại mật khẩu</label>
                                            <div class="form col-xs-9">
                                                <input type="password" class="input-form" placeholder="Nhập lại mật khẩu mới" name="new-password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!--box-additional-information-->

                                    <div class="text-center">
                                        <a href="#" class="btn btn-default-yellow btn-popup" onclick="return jQuery('#form-change-password').submit();">Thay đổi mật khẩu</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--box-personal-information-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->

@endsection