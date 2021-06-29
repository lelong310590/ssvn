@if(count($topTeachers)>0)
<div class="vj-teacher">
    <div class="container">
        <div class="row">
            @foreach($topTeachers as $teacher)
            <div class="col-md-6">
                <a href="{{ route('front.users.profile.get',['code'=>$teacher->getDataByKey('code_user')]) }}" class="tch-img">
                    <img src="{{ asset($teacher->thumbnail) }}" alt="" title="" />
                </a>
                <div class="overflow tch">
                    <h4><a href="{{ route('front.users.profile.get',['code'=>$teacher->getDataByKey('code_user')]) }}">{{ $teacher->first_name }}</a></h4>
                    <div class="content" style="max-height: 55px; overflow: hidden; margin-bottom: 10px">
                        {!! nl2br(e($teacher->getDataByKey('description'))) !!}
                    </div>
                    <div class="tch-it">
                        <span><i class="far fa-user-tie"></i>{{number_format($teacher->getTotalStudent())}} học sinh</span>
                        <span><i class="fal fa-book"></i> {{$teacher->course()->where('status', 'active')->count()}} Khóa đào tạo</span>
                    </div>
                    <a class="tch-ol" href="#">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a class="tch-ol" href="#">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--teacher-->
@endif