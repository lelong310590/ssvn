<div class="modal dark_bg fade" id="modal-icon" tabindex="-1" role="dialog" aria-labelledby="modal-icon" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-icon">Chọn icon cho Chứng chỉ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<ul class="list-inline trip-icon-list">
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-happy"></i></a></li>
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-wink"></i></a></li>
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-unhappy"></i></a></li>
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-sleep"></i></a></li>
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-thumbsup"></i></a></li>
					<li><a href="javascript:;" class="trip-icon"><i class="demo-icon icon-emo-devil"></i></a></li>
				</ul>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

@push('css')
<link rel="stylesheet" href="{{asset('adminux/css/trip-icon.css')}}">
@endpush