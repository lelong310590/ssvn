<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/images/icons/favicon.ico') }}"/>
    @inject('settingRepository', 'Setting\Repositories\SettingRepository')

    @php
        $title = Cache::remember('title', 60 * 60 * 24, function () use ($settingRepository) {
            return $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
        });

        $tagline = Cache::remember('tagline', 60 * 60 * 24, function () use ($settingRepository) {
            return $settingRepository->findWhere(['name' => 'seo_tagline'], ['content'])->first();
        });
    @endphp

    <meta name="author" content="{{!empty($title) ? $title->content : ''}}">

    @if (Route::is('front.home.index.get'))
        <title>{{!empty($title) ? $title->content : ''}}</title>
        @php
            $description = Cache::remember('description', 60 * 60 * 24, function () use ($settingRepository) {
                return $settingRepository->findWhere(['name' => 'seo_description'], ['content'])->first();
            });

            $keywords = Cache::remember('keywords', 60 * 60 * 24, function () use ($settingRepository) {
                return $settingRepository->findWhere(['name' => 'seo_keywords'], ['content'])->first();
            });
        @endphp
        <meta name="title" content="{{!empty($title) ? $title->content : ''}}">
        <meta name="description" content="{{!empty($description) ? $description->content : ''}}">
        <meta name="keyword" content="{{!empty($keywords) ? $keywords->content : ''}}">
    @else
        <title>@yield('title') | {{!empty($tagline) ? $tagline->content : ''}}</title>
        <meta name="title" content="@yield('seo_title')">
        <meta name="description" content="@yield('seo_description')">
        <meta name="keyword" content="@yield('seo_keywords')">
    @endif

    <meta property="og:title" content="@yield('og_title')"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="@yield('og_url')"/>
    <meta property="og:image" content="@yield('og_image')"/>

    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/fontawesome5/fontawesome-all.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/css/style-new.css')}}"/>

@yield('css')
@stack('css')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-65991607-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-65991607-2');
</script>

</head>


<body {{(Route::currentRouteName() == 'front.home.index.get' ? 'class="home-page"' : '')}}>

<div id="fb-root"></div>

@include('nqadmin-dashboard::frontend.header')

@include('nqadmin-dashboard::frontend.partials.flash-message')

@yield('content')

@include('nqadmin-dashboard::frontend.footer')

<script src="{{asset('frontend/js/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>

@yield('js')
@yield('js-init')
@stack('js')
@stack('js-init')

{{--<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>--}}
<script src="{{asset('frontend/js/javascript.js')}}"></script>

{{--<script>--}}
    {{--(function (d, s, id) {--}}
        {{--var js, fjs = d.getElementsByTagName(s)[0];--}}
        {{--if (d.getElementById(id)) return;--}}
        {{--js = d.createElement(s);--}}
        {{--js.id = id;--}}
        {{--js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=1642028219373274&autoLogAppEvents=1';--}}
        {{--fjs.parentNode.insertBefore(js, fjs);--}}
    {{--}--}}
    {{--(document, 'script', 'facebook-jssdk'));</script>--}}

<script src="https://apis.google.com/js/platform.js" async defer>
    {
        lang: 'vi'
    }
</script>

</body>

</html>