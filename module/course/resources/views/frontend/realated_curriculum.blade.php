@inject('courseCurriculumItemsRepository','Course\Repositories\CourseCurriculumItemsRepository')
@inject('mediaRepository','Media\Repositories\MediaRepository')

@php
    $allitem = $courseCurriculumItemsRepository->orderBy('index', 'asc')
    ->with(['getAllQuestion', 'getMedia' => function($media) {
                return $media->select('curriculum_item', 'duration')->where('type', 'video/mp4')->where('status', 'active');
            }])
    ->findWhere([
        'status' => 'active',
        'course_id' => $course->id,
    ], ['id', 'name', 'type', 'preview', 'parent_section']);

    $section = $allitem->filter(function ($value, $key) {
        return $value->type == 'section';
    });

    $lecture = $allitem->filter(function ($value, $key) {
        return $value->type != 'section';
    });

    if ($course->type == 'test') {
        $question = 0;
        foreach ($lecture as $c) {
            $question += count($c->getAllQuestion);
        }
        $total = $question;
    }
@endphp

<h4 class="txt-title-home">Danh sách các bài học</h4>
@foreach($section as $s)
    <div class="panel-group lesson-group" id="{{$s->slug}}" role="tablist" aria-multiselectable="true">
        @php
            $curri = $lecture->filter(function($value, $key) use ($s) {
                return $value->parent_section == $s->id;
            });

            $total = $curri->count();
        @endphp

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-{{$s->id}}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#{{$s->slug}}" href="#collapse-{{$s->id}}" aria-expanded="true" aria-controls="collapse-{{$s->id}}">
                        <span class="lesson-name"><b>{{$s->name}}</b></span>
                        @if ($course->type == 'test')
                            <span class="lesson-total"><b>- ({{$total}} câu hỏi)</b></span>
                        @else
                            <span class="lesson-total"><b>- ({{$total}} bài học)</b></span>
                        @endif
                        {{--<span class="lesson-time">{{secToHR($allDuration, true)}}</span>--}}
                    </a>
                </h4>
            </div>

            <div id="collapse-{{$s->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-{{$s->id}}">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($curri as $c)
                            @php
                                if ($c->getMedia->isNotEmpty()) {
                                    $duration = $c->getMedia->first()->duration;
                                } else {
                                    $duration = null;
                                }
                            @endphp

                            <li class="list-group-item">
                                @if ($c->type == 'test')
                                    <i class="lesson-icon far fa-file-alt"></i>
                                @else
                                    <i class="lesson-icon far fa-play-circle"></i>
                                @endif

                                <span class="lesson-name">{{$c->name}}</span>
                                @if ($c->preview == 'active')
                                    <a href="#" class="lesson-preview" onclick="viewvideo({{$c->id}});return false;">Xem</a>
                                @endif
                                @if (!empty($duration))
                                    <span class="lesson-time">{{secToHR($duration, true)}}</span>
                                @endif
                                @if ($course->type == 'test')
                                    <span class="lesson-time">{{count($c->getAllQuestion)}} câu hỏi</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
@push('js')
<script type="text/javascript">
    function viewvideo(id) {
        var player = videojs('my-video');
        $('#previewPromo').modal();
        $('#video'+id).click();
    }
</script>
@endpush