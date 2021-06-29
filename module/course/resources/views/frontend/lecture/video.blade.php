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
		$title = $settingRepository->findWhere(['name' => 'seo_title'], ['content'])->first();
        $tagline = $settingRepository->findWhere(['name' => 'seo_tagline'], ['content'])->first();
		$description = $course->getLdp()->select('excerpt')->where('id', $course->id)->first();
	@endphp

	<meta name="author" content="{{!empty($title) ? $title->content : ''}}">

	<title>{{$course->name}} | {{!empty($tagline) ? $tagline->content : ''}}</title>

	<meta name="title" content="{{$course->name}}">
	<meta name="description" content="{{!empty($description) ? $description->excerpt : ''}}">
	<meta name="keyword" content="@yield('seo_keywords')">

	<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('frontend/fontawesome5/fontawesome-all.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}"/>

	<meta name="description" content=""/>
	<link href="//vjs.zencdn.net/6.7/video-js.min.css" rel="stylesheet">
	<link href="{{ asset('frontend/css/video.min.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" href="{{asset('frontend/css/style.css')}}"/>
	
	@yield('css')
	@stack('css')
	
	
</head>

@php
    $user = Auth::user();
    $check = $user->checkDoExam($course->id);
@endphp

<body>
	<div class="col-xs-12" style="padding: 0">
		<div
			id="Single"
			class="center-block"
			data-userid="{{ Auth::id()}}"
			data-courseid="{{$course->id}}"
			data-lecture="{{$lecture->id}}"
			data-lecturetype="{{$lecture->type}}"
			data-type="{{$type}}"
			data-status="{{$status}}"
			data-timestart="{{strtotime($course->time_start)}}"
			data-timeend="{{strtotime($course->time_end)}}"
			data-isexam="{{$course->type == 'exam' ? true : false}}"
            data-doexam="{{$check}}"
		>
		</div>
	</div>
	
	<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
	<script src="https://cdn.tiny.cloud/1/1mkudqklng9crolevl4317aes2au2e24j1zzu6z1oq8excw7/tinymce/4.9.11-104/tinymce.min.js"></script>
</body>
</html>