@inject('settingRepository', 'Setting\Repositories\SettingRepository')

@php
    $description = $course->getLdp()->select('excerpt')->first();
@endphp

@section('title', $course->name)
@section('seo_title', $course->name)
@section('seo_description', !empty($description) ? $description->exceprt : '')
@section('seo_keywords', '')

<?php

use Users\Models\Users;
?>
@extends('nqadmin-dashboard::frontend.master')
@section('content')
    <div class="main-page">
        <div class="page-course">

            @include('nqadmin-course::frontend.course.boughttop')

            <div class="container">
            <!--top-course-->

                <div class="content-course">
                @include('nqadmin-course::frontend.components.box-filtered')
                <!--box-filtered-->

                    <div class="box-detail-question">
                        @foreach($question as $q)
                            <a name="{{ $q->id }}"></a>
                            <div class="list-course-announcement">
                                <div class="top-course-announcement clearfix box-info">
                                    <a href="#" class="img pull-left">
                                        @include('nqadmin-users::frontend.components.user.thumbnail',['user'=>$q->owner])
                                    </a>
                                    <div class="overflow">
                                        <h4 class="name"><a href="javascript:void(0);">{{ $q->title }}</a></h4>
                                        <p class="clearfix">
                                            <a href="{{ route('front.users.profile.get',['code'=>$q->owner->getDataByKey('code_user')]) }}">{{ $q->owner->first_name }}</a> -
                                            <a href="{{ route('nqadmin::course.lecture.learn',['slug'=>$q->getCourse->slug,'lectureId'=>$q->getLecture->id]) }}">{{ $q->getLecture->name }}</a> -
                                            {{ time_elapsed_string($q->created_at) }} <i class="fab fa-font-awesome-flag"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="content-course-announcement">
                                    {!! $q->content !!}
                                </div>
                                <div class="comment-course">
                                    <div class="main-comment-course">
                                        @foreach($q->getAnswer as $answer)
                                            <div class="list-comment">
                                                <div class="left">
                                                    <a href="#" class="img pull-left img-circle">
                                                        <img src="{{asset(isset($answer->owner->thumbnail)?$answer->owner->thumbnail:'adminux/img/course-df-thumbnail.jpg')}}" alt="" width=""
                                                             height="">
                                                    </a>
                                                    <div class="overflow content">
                                                        <div class="top clearfix">
                                                            <h4 class="name pull-left"><a href="#">{{ $answer->owner->first_name }}</a></h4>
                                                            <span class="overflow">{{ time_elapsed_string($answer->created_at) }} <i class="fab fa-font-awesome-flag"></i> </span>
                                                        </div>
                                                        <div class="des">
                                                            {!!  $answer->content !!}
                                                        </div>
                                                        {{--<a href="#" class="tick">Đánh dấu có ích (1)</a>--}}
                                                    </div>
                                                </div>
                                                <div class="right editor">
                                                    <div class="right-editor">
                                                        <a href="javascript:void(0)" class="icon-exclamation"><i class="fas fa-ellipsis-v"></i></a>
                                                        <div class="link box-dropdown">
                                                            <div class="form-dropdown form-dropdown-top-right">
                                                                <div class="list clearfix">
                                                                    <a href="#">
                                                                        <i class="fas fa-exclamation pull-left"></i>
                                                                        <p class="overflow">Báo cáo sai phạm</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="top-comment-course">
                                        <form class="box-form-default" enctype="multipart/form-data" method="post" action="{{ route('front.users.reply_question.post') }}" id="reply-{{ $q->id }}">
                                            {{ csrf_field() }}
                                            <div class="content">
                                                <form class="box-form-default">
                                                    <div class="editor">
                                                        <div class="left-editor">
                                                            <textarea name="contentt" class="input-form" required></textarea>
                                                        </div>
                                                        <div class="submit-comment">
                                                            <input type="hidden" name="id" value="{{ $q->id }}">
                                                            <button type="button" class="btn btn-default-yellow" onclick="$('#reply-{{ $q->id }}').submit()">Thêm câu trả lời</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--list-course-announcement-->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-page-->
@endsection
@push('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/4.9.11-104/tinymce.min.js"></script>
    <script>
        $('#filter_form input,select').change(function () {
            $("#filter_form").submit();
        })
        tinymce.init({
            selector: 'textarea',
            menubar: false,
            statusbar: false,
            plugins: [
                "link image code codesample autoresize",
            ],
            toolbar1: "link image code codesample",
            // enable title field in the Image dialog
            image_title: true,
            // enable automatic uploads of images represented by blob or data URIs
            automatic_uploads: true,
            // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
            // images_upload_url: 'postAcceptor.php',
            // here we add custom filepicker only to Image dialog
            file_picker_types: 'image',
            // and here's our custom image picker
            // file_picker_callback: function(cb, value, meta) {
            //     var input = document.createElement('input');
            //     input.setAttribute('type', 'file');
            //     input.setAttribute('accept', 'image/*');
            //
            //     // Note: In modern browsers input[type="file"] is functional without
            //     // even adding it to the DOM, but that might not be the case in some older
            //     // or quirky browsers like IE, so you might want to add it to the DOM
            //     // just in case, and visually hide it. And do not forget do remove it
            //     // once you do not need it anymore.
            //
            //     input.onchange = function() {
            //         var file = this.files[0];
            //
            //         var reader = new FileReader();
            //         reader.onload = function () {
            //             // Note: Now we need to register the blob in TinyMCEs image blob
            //             // registry. In the next release this part hopefully won't be
            //             // necessary, as we are looking to handle it internally.
            //             var id = 'blobid' + (new Date()).getTime();
            //             var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            //             var base64 = reader.result.split(',')[1];
            //             var blobInfo = blobCache.create(id, file, base64);
            //             blobCache.add(blobInfo);
            //
            //             // call the callback and populate the Title field with the file name
            //             cb(blobInfo.blobUri(), { title: file.name });
            //         };
            //         reader.readAsDataURL(file);
            //     };
            //
            //     input.click();
            // },
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = '<?php echo env('APP_URL');?>' + 'cdn-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        });
    </script>
@endpush