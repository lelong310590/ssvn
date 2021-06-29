@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="{{asset('adminux/js/sortable-init.js')}}" type="text/javascript"></script>
@endpush

@empty($target)

<div class="card-body">
	<p>Bạn đang trên đường để tạo ra một Khóa đào tạo! Các mô tả bạn viết ở đây sẽ giúp học sinh quyết định xem Khóa đào tạo của bạn là khoá học nào cho chúng.</p>
	<br>
	<div class="target-wrapper">
		<p>Về kiến thức</p>
		<div class="row">
			<ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_1')}}">
				<li class="ui-state-default">
					<input type="text"
					       class="form-control target-input-content"
					       autocomplete="off"
					       placeholder="{{config('course.target_ph_1')}}"
					       data-name-value="required[]"
					>
					<i class="fa fa-bars move-item"></i>
					<a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
				</li>
			</ul>
			<div class="sortable-add-more col-sm-16 float-left">
				<a href="" class="sortable-add-more-button" data-name-value="required[]"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
			</div>
		</div>
	</div>
	
	<div class="target-wrapper">
		<p>Về kỹ năng</p>
		<div class="row">
			<ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_2')}}">
				<li class="ui-state-default">
					<input type="text"
					       class="form-control target-input-content"
					       autocomplete="off"
					       data-name-value="who[]"
					       placeholder="{{config('course.target_ph_2')}}"
					>
					<i class="fa fa-bars move-item"></i>
					<a href="" class="target-delete-item"><i class="fa fa-times"></i></a>
				</li>
			</ul>
			<div class="sortable-add-more col-sm-16 float-left">
				<a href="" class="sortable-add-more-button" data-name-value="who[]"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
			</div>
		</div>
	</div>
	
	<div class="target-wrapper">
		<p>Học sinh sẽ đạt được những gì hoặc có thể làm sau khi tham gia Khóa đào tạo?</p>
		<div class="row">
			<ul class="col-sm-16 sortable" data-placeholder="{{config('course.target_ph_3')}}">
				<li class="ui-state-default">
					<input type="text"
					       class="form-control target-input-content"
					       autocomplete="off"
					       data-name-value="what[]"
					       placeholder="{{config('course.target_ph_3')}}"
					>
					<i class="fa fa-bars move-item"></i>
					<a href="" class="target-delete-item" data-name-value="what[]"><i class="fa fa-times"></i></a>
				</li>
			</ul>
			<div class="sortable-add-more col-sm-16 float-left">
				<a href="" class="sortable-add-more-button"><i class="fa fa-plus"></i> <b>Thêm câu trả lời</b></a>
			</div>
		</div>
	</div>
</div>

@else

@include('nqadmin-course::backend.coursetarget.edit')

@endempty