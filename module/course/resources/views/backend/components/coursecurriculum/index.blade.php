@push('js-react')
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@endpush

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('js')
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>--}}
{{--<script src="{{asset('adminux/js/sortable-init.js')}}" type="text/javascript"></script>--}}
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/4.9.11-104/tinymce.min.js"></script>
@endpush

<div class="fixed-title-course">

</div>

<div class="card-body">
	<p><b>Bắt đầu kết hợp Khóa đào tạo của bạn bằng cách tạo các phần, bài giảng và thực hành (các câu đố và các bài tập mã hóa) dưới đây.</b></p>
	<br>
	<div id="Curriculum" data-userid="{{ Auth::id() }}" data-coursetype="{{$course->type}}"></div>
</div>