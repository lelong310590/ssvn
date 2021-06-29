@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
    $description = $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
    $keywords = $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
@endphp

@section('title', 'Thanh toán Khóa đào tạo')
@section('seo_title', 'Thanh toán Khóa đào tạo')
@section('seo_description', $description->content)
@section('seo_keywords', $keywords->content)

@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="page-pay">
            <div class="container">
                <div class="row ">
                    <div class="col-xs-3 left-pay">
                        <form class="box-form-default" method="post" action="{{ route('front.cart.checkout.post') }}">
                            @include('nqadmin-cart::frontend.component.order')
                        </form>
                    </div>
                    <div class="col-xs-9 right-pay">
                        <div class="info-pay">
                            @include('nqadmin-cart::frontend.component.buyer')
                        </div>
                        <!--info-pay-->

                        <div class="box-tab-pay">
                            @include('nqadmin-cart::frontend.component.payment')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection
@section('js')
    <script>
        $('.page-pay .right-pay .form-info-user .txt-form').change(function () {
            var $this = $(this);
            var name = $(this).attr('name');
            var value = $(this).val();
            if (value != '') {
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
                        $this.parent().addClass('checked');
                    }
                })
            }
        });

        function checkcode() {
            var code = $('#coupon_code').val();
            if (code != '')
                window.location.href = "{!! route('front.cart.checkout.get') !!}" + "?code=" + code;
        }

        $('.nav-link').click(function () {
            var value = $(this).attr('aria-controls');
            $('input[name=payment_method]').val(value)
        });
    </script>
@endsection