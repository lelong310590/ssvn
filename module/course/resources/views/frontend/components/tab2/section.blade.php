<div class="box-resources">
    @foreach($datas as $cur)
        <div class="list-resources {{ $cur->id==$lecture->parent_section?'show-all':'' }}">
            <div class="top-resources">
                <div class="left">
                    <h4 class="title">Section: {{ $loop->iteration	 }} </h4>
                    <p class="name">{{ $cur->name }}</p>
                </div>
                <div class="right">
                    <p><span>{{ $cur->getFinishItem() }}</span>/{{ $cur->getLession()->count() }}</p>
                </div>
            </div>
            <div class="content-resources col-xs-12">
                @foreach($cur->getLession(request('keyword')) as $lession)
                    <div class="row list {{ $lession->id==$lecture->id?'active':'' }}">
                        <div class="col-xs-8">
                            <a href="{{ route('nqadmin::course.lecture.learn',['slug'=>$course->slug,'lectureId'=>$lession->id]) }}">
                                <i class="far fa-play-circle"></i>
                                {{ $lession->name }}
                            </a>
                        </div>
                        <div class="col-xs-4 text-right">
                            <div class="pull-right">
                                <div class="pull-left check {{ $lession->checkFinish() == 3?'checked':'' }}">
                                    @if(isset($lession->getMedia->where('type','video/mp4')->first()->duration))
                                        {{ secToHR($lession->getMedia->where('type','video/mp4')->first()->duration, true) }}
                                    @endif
                                    <i class="far fa-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($download)
                        <div class="row list">
                            @foreach($lession->getMedia as $media)
                                @if($media->type!='video/mp4')
                                    <div class="col-xs-12 download">
                                        <a href="{{ asset($media->url) }}" class="btn-download" download="{{ $media->name }}">
                                            <i class="fas fa-download"></i>{{ $media->name }}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach

</div>