<div class="card">
	<div class="card-header">
		<h5 class="card-title">Gallery</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-16">
				<div class="gallery-zone col-md-16">
					<div class="row" id="gallery-zone">
						@if (isset($data) && !empty($data))
							@php
								$gallery = json_decode($data->gallery);
							@endphp
							
							@foreach($gallery as $g)
								<div class="col-md-4">
									<div class="gallery-item">
										<a href="javascript:;" class="delete-gallery-item">X</a>
										<img src="{{asset($g)}}" alt="" class="img-fluid m-auto" data-sync="{{'g'.$loop->index}}">
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
		<div id="gallery-value">
			@if (isset($data) && !empty($data))
				@php
					$gallery = json_decode($data->gallery);
				@endphp
				
				@foreach($gallery as $g)
					<input type="hidden" value="{{$g}}" name="gallery[]" data-sync="{{'g'.$loop->index}}">
				@endforeach
			@endif
		</div>
		<div class="input-group">
			<a data-input="thumbnail" data-preview="holder" class="lfm-gallery btn btn-primary" href="javascript:;" style="margin-right: 10px">
				<i class="fa fa-picture-o"></i> Chọn ảnh
			</a>
			
			<a id="delete-lfm-gallery" data-input="thumbnail" data-preview="holder" class="btn btn-danger" href="javascript:;">
				<i class="fa fa-trash-o"></i> Xóa Gallery
			</a>
		</div>
	</div>
</div>

@push('js')
<script>
	(function( $ ){
		$.fn.filemanager = function(type, options) {
			type = type || 'file';

			this.on('click', function(e) {
				var route_prefix = (options && options.prefix) ? options.prefix : '/cdn-filemanager';
				localStorage.setItem('target_input', $(this).data('input'));
				localStorage.setItem('target_preview', $(this).data('preview'));
				window.open(route_prefix + '?type=' + type, 'FileManager', 'width=1024,height=768');
				window.SetUrl = function (url, file_path) {
					var syncValue = new Date().getTime();
					var html = '';
					html += '<div class="col-md-4">';
					html += '<div class="gallery-item">';
					html += '<a href="javascript:;" class="delete-gallery-item">X</a>';
					html += '<img src="' + url + '" alt="" class="img-fluid m-auto" data-sync="' + syncValue + '">';
					html += '</div>';
					html += '</div>';

					var input = '';
					input += '<input type="hidden" value="' + file_path + '" name="gallery[]" data-sync="' + syncValue + '"/>';

					$('#gallery-zone').append(html);
					$('#gallery-value').append(input);
				};
				return false;
			});
		}
	})(jQuery);

	$('.lfm-gallery').filemanager('image');
	$('body').on('click', '.delete-gallery-item', function (e) {
		var elem = $(e.currentTarget);
		var syncValue = elem.next('img').attr('data-sync');
		$('input[data-sync="'+syncValue+'"]').remove();
		var t = confirm("Bạn có chắc chắn muốn xóa ảnh này");
		if (t === true) {
			elem.parents('.col-md-4').remove();
		}
	})

	$('#delete-lfm-gallery').on('click', function (e) {
		e.preventDefault();
		$('#gallery-zone').empty();
		$('#gallery-value').empty();
	})

</script>
@endpush