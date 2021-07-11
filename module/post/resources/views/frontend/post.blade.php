@extends('nqadmin-dashboard::frontend.master')

@section('content')

<div class="main-page">
    <div class="container">
        <div class="post-wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-9 col-md-push-3">
                    @foreach($post as $p)
                        <h1 class="post-title">{{$p->name}}</h1>
                        <div class="post-content">
                            {!! $p->content !!}
                        </div>
                    @endforeach
                </div>
                <div class="col-xs-12 col-md-3 col-md-pull-9">
                    <div class="post-sidebar">
                        <ul>
                            @foreach($sidePost as $p)
                            <li><a href="{{route('front::post.get', $p->slug)}}">{{$p->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection