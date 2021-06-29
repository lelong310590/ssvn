{{csrf_field()}}
<div class="card-body">
    <div class="form-group">
        <label class="form-control-label"><b>Thời gian bắt đầu</b></label>
        <div class='input-group date datetimepicker'>
            <input
                    type='text'
                    class="form-control"
                    name="time_start"
                    @if (!empty($course->time_start))
                    value="{{date('d/m/Y H:i:s', strtotime($course->time_start)) }}"
                    @else
                    value="{{date('d/m/Y H:i:s', strtotime(\Carbon\Carbon::now())) }}"
                    @endif
            />
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>

    </div>

    <div class="form-group">
        <label class="form-control-label"><b>Thời gian kết thúc</b></label>
        <div class='input-group date datetimepicker'>
            <input
                    type='text'
                    class="form-control"
                    name="time_end"
                    @if (!empty($course->time_end))
                    value="{{date('d/m/Y H:i:s', strtotime($course->time_end)) }}"
                    @else
                    value="{{date('d/m/Y H:i:s', strtotime(\Carbon\Carbon::tomorrow())) }}"
                    @endif
            />
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
</div>
