<div class="card">
	<div class="card-header">
		<h5 class="card-title">Ảnh đại diện</h5>
	</div>
	<div class="card-body">
		<img id="holder"
		     style="margin-bottom:10px; width: 100%"
		     class="img-fluid"
		     @if (isset($data->thumbnail))
		        src="{{ (!empty($data->thumbnail)) ? asset($data->thumbnail) : asset('adminux/img/no-image.jpg') }}"
		     @else
		        src="{{ (!empty(old('thumbnail'))) ? asset(old('thumbnail')) : asset('adminux/img/no-image.jpg') }}"
		     @endif
		>
		<div class="input-group">
			<a data-input="thumbnail" data-preview="holder" class="lfm btn btn-primary" href="javascript:;" style="margin-right: 10px">
				<i class="fa fa-picture-o"></i> Chọn ảnh
			</a>
			
			<a id="delete-lfm" data-input="thumbnail" data-preview="holder" class="btn btn-danger" href="javascript:;">
				<i class="fa fa-trash-o"></i> Xóa ảnh
			</a>
			@if (isset($data->thumbnail))
				<input id="thumbnail" class="form-control" type="hidden" name="thumbnail" value="{{$data->thumbnail}}">
			@else
				<input id="thumbnail" class="form-control" type="hidden" name="thumbnail">
			@endif
		</div>
	</div>
</div>

@push('js')
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<script>
	$('.lfm').filemanager('image');
	$('#delete-lfm').on('click', function () {
		$('#thumbnail').val('');
		$('#holder').attr('src', '{{ asset('adminux/img/no-image.jpg') }}');
	})
</script>
@endpush