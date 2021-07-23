@extends('nqadmin-dashboard::frontend.master')

@inject('settingRepository', 'Setting\Repositories\SettingRepository')
@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
@endphp

@section('title', $title != null ? $title->content : '')
@section('seo_title', $title != null ? $title->content : '')
@section('seo_description', $description != null ? $description->content : '')
@section('seo_keywords', $keywords != null ? $keywords->content : '')

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
                            <h3 class="txt">Thông tin cá nhân</h3>
                        </div>
                        <form method="post" action="{{ route('front.users.info.post') }}" id="information-form">
                            {{ csrf_field() }}
                            <div class="box-personal-information">
                                <div class="box-form-default">
                                    <div class="box-update-information">
                                        <h4 class="txt-title">Cập nhật thông tin cá nhân</h4>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Số CCCD/CMND</label>
                                            <div class="form col-xs-12 col-md-7">
                                                <input type="text" class="input-form" value="{{ $data->citizen_identification }}"
                                                       name="citizen_identification" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Họ</label>
                                            <div class="form col-xs-12 col-md-7">
                                                <input type="text" class="input-form" value="{{ $data->first_name }}"
                                                       name="first_name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Tên và tên đệm</label>
                                            <div class="form col-xs-12 col-md-7">
                                                <input type="text" class="input-form" value="{{ $data->last_name }}"
                                                       name="last_name">
                                            </div>
                                        </div>

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Bạn là</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.select',['name'=>'position','options'=>config('meta.position'),'type'=>'small'])--}}
{{--                                        </div>--}}

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Ngày sinh</label>
                                            <div class="form col-xs-7">
                                                <input type="date" class="input-form" name="dob" value="{{ $data->dob != null ? $data->dob->format('Y-m-d') : ''}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Giới tính</label>
                                            <div class="form col-xs-7">
                                                <select class="input-form" name="sex">
                                                    <option value="male" {{ ($data->sex == 'male') ? 'selected' : '' }}>Nam</option>
                                                    <option value="female" {{ ($data->sex == 'female') ? 'selected' : '' }}>Nữ</option>
                                                    <option value="other" {{ ($data->sex == 'other') ? 'selected' : '' }}>Khác</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Số điện thoại</label>
                                            <div class="form col-xs-7">
                                                <input type="text" class="input-form" name="phone" value="{{ $data->phone  }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Địa chỉ Email</label>
                                            <div class="form col-xs-7">
                                                <input type="email" class="input-form" name="email" value="{{ $data->email  }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="txt-label col-xs-3 text-right">Công ty</label>
                                            <div class="form col-xs-12 col-md-7">
                                                <select class="input-form" disabled>
                                                    @foreach($classLevel as $lv)
                                                        <option value="{{$lv->id}}" {{$lv->id == $data->classlevel ? 'selected' : ''}}>
                                                            {{$lv->name}} - MST: {{$lv->mst}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--box-update-information-->

                                    <div class="box-image-update">
                                        <h4 class="txt-title">Cập nhật hình ảnh</h4>

                                        @include('nqadmin-users::frontend.components.info.upload-image',['name'=>'thumbnail'])
                                    </div>
                                    <!--box-image-update-->

{{--                                    <div class="box-additional-information">--}}
{{--                                        <h4 class="txt-title">Thông tin bổ sung</h4>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Thành phố</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.select_api',['name'=>'city','options'=>$data->city])--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Quận/Huyện</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.select_api',['name'=>'province','options'=>$data->province])--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Công ty</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.select',['name'=>'class','options'=>config('meta.class')])--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Tên công ty</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.text',['name'=>'class_name'])--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <label class="txt-label col-xs-3 text-right">Trường</label>--}}
{{--                                            @include('nqadmin-users::frontend.components.info.text',['name'=>'class_school'])--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!--box-additional-information-->--}}

{{--                                    @include('nqadmin-users::frontend.components.info.giao_vien')--}}
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-default-yellow">Cập nhật thông tin</button>
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

@section('js')
    <script>
        $(function () {
            var $win = $(window); // or $box parent container
            var $box = $(".box-form-default").find(".box-select");

            $win.on("click.Bst", function (event) {
                if (
                    $box.has(event.target).length == 0 //checks if descendants of $box was clicked
                    &&
                    !$box.is(event.target) //checks if the $box itself was clicked
                ) {
                    $box.find(".list-select").css('display', 'none');
                }
            });

        });

        $(document).on("click", ".box-form-default .box-select .list-select li", function () {
            var $parent = $(this).parent().parent();
            var name = $(this).attr('class');
            var id_value = name + '_value';
            var id_show = name + '_show';
            $parent.find('.' + id_value).val($(this).attr('data-value'));
            $parent.find('.' + id_show).html($(this).attr('rel'));
            $(this).parent().css('display', 'none');

            if (name == 'position') {
                if ($(this).attr('data-value') == 'giao_vien') {
                    $('div.giao_vien').removeClass('hidden');
                } else {
                    $('.giao_vien').addClass('hidden');
                }
            }

            if (name == 'city') {
                var city_id = $(this).attr('alt');
                $('#province_list').html('');
                $.ajax({
                    type: 'POST',
                    url: '{!! route('front.users.province.post') !!}',
                    data: {
                        _token: "{!! csrf_token() !!}",
                        city_id: city_id
                    },
                    dataType: 'json',
                    error: function (data) {
                        console.log(data);
                    },
                    success: function (data) {
                        var first_province = data[0].district_name;
                        $('#province_list').parent().find('.province_value').val(first_province);
                        $('#province_list').parent().find('.province_show').html(first_province);
                        var li_string = '';
                        for (var i in data) {
                            li_string += '<li class="province" rel="' + data[i].district_name + '" data-value="' + data[i].district_name + '">' + data[i].district_name + '</li>';
                        }
                        $('#province_list').html(li_string);
                    }
                })
            }
        });

        $(document).on("click", ".box-form-default .form .change-form .cancel, .box-form-default .form .change-form .save", function () {
            var $parent = $(this).parents().eq(4);
            var name = $(this).attr('rel');
            var id_value = name + '_value';
            var id_show = name + '_show';
            var value = $parent.find('.' + id_value).val();
            $.ajax({
                type: 'POST',
                url: '{!! route('front.users.contact.post') !!}',
                data: {
                    _token: "{!! csrf_token() !!}",
                    key: name,
                    value: value,
                },
                dataType: 'json',
                error: function (data) {
                    console.log(data);
                },
                success: function (data) {
                    $parent.find('.' + id_value).val(data.value);
                    $parent.find('.' + id_show).html(data.value);
                }
            })
        });

        $('input[type="file"]').on('change', function () {
            //Lấy ra files
            var file_data = $(this).prop('files')[0];
            //lấy ra kiểu file
            var type = file_data.type;

            //Xét kiểu file được upload
            var match = ["image/gif", "image/png", "image/jpg", "image/jpeg"];
            var check = match.indexOf(type);
            //kiểm tra kiểu file
            if (check >= 0) {
                //khởi tạo đối tượng form data
                var form_data = new FormData();
                //thêm files vào trong form data
                form_data.append('file', file_data);
                form_data.append('_token', '{!! csrf_token() !!}');
                //sử dụng ajax post
                $.ajax({
                    url: '{!! route('front.users.avatar.post') !!}',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (res) {
                        $('.thumbnail_image').attr('src', res.image);
                    }
                });
            } else {
                alert('Không đúng định dạng');
            }
            return false;
        });
    </script>
@endsection