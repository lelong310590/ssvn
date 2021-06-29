<?php

use Users\Models\Users;
?>
@extends('nqadmin-dashboard::frontend.master')
@section('content')

    <div class="main-page">
        <div class="page-course-management">
            <div class="container">
                <div class="box-overview-management">
                    <div class="box-filtered text-center top-overview-management">
                        @include('nqadmin-users::frontend.components.quan_ly_khoa_hoc.topmenu')
                    </div>
                    <!--top-overview-management-->

                    <div class="box-overview-qa row">
                        <div class="col-xs-3 left-overview-qa">
                            <form id="filter_form" class="box-form-default" method="get" action="">
                                <div class="box-dropdown-single">
                                    <div class="dropdown-single">
                                        <select class="show-txt" name="course">
                                            <option value="0">Tất cả các Khóa đào tạo</option>
                                            @foreach($courselist as $c)
                                                <option value="{{ $c->id }}" <?php if(isset($_REQUEST['course'])&&$_REQUEST['course']== $c->id){echo 'selected';}?>>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        {{--<span class="show-txt">Tất cả các Khóa đào tạo<i class="fas fa-chevron-down pull-right"></i></span>--}}
                                        {{--<ul class="form-dropdown">--}}
                                        {{--<li><a href="#" class="active">Tất cả các Khóa đào tạo</a> </li>--}}
                                        {{--<li><a href="#">Cũ nhất</a> </li>--}}
                                        {{--<li><a href="#">Quan tâm nhất</a> </li>--}}
                                        {{--</ul>--}}
                                    </div>
                                </div>

                                <div class="box-choose">
                                    <div class="form-group form-check">
                                        <label>
                                            <input type="checkbox" name="check[]" value="0" <?php if (isset($_REQUEST['check']) && in_array('0', $_REQUEST['check'])) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            Chưa đọc ({{ $unread }})
                                        </label>
                                    </div>
                                    <div class="form-group form-check">
                                        <label>
                                            <input type="checkbox" value="1" name="check[]" <?php if (isset($_REQUEST['check']) && in_array('1', $_REQUEST['check'])) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            Không có câu trả lời hàng đầu ({{ $topcmt }})
                                        </label>
                                    </div>
                                    <div class="form-group form-check">
                                        <label>
                                            <input type="checkbox" value="2" name="check[]" <?php if (isset($_REQUEST['check']) && in_array('2', $_REQUEST['check'])) {
                                                echo 'checked';
                                            }?>>
                                            <span class="icon"><i class="far fa-square"></i></span>
                                            Không có hồi âm ({{ $notreply }})
                                        </label>
                                    </div>
                                </div>

                                <div class="box-dropdown-single">
                                    <span class="txt">Sắp xếp theo:</span>
                                    <div class="dropdown-single">
                                        <select class="show-txt" name="question">
                                            <option value="0">Mới nhất</option>
                                            <option value="1" <?php if (isset($_REQUEST['question']) && $_REQUEST['question'] == 1) {
                                                echo 'selected';
                                            }?>>Cũ nhất
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-9 right-overview-qa">
                            <div class="box-detail-question">
                                @foreach($questions as $question)
                                    <div class="list-course-announcement <?php echo $question->readed == 0 ? 'readed' : 'unread';?>">
                                        <div class="top-course-announcement clearfix box-info">
                                            <?php
                                            $ldp = DB::table('course_ldp')
                                                ->where('course_id', $question->course)
                                                ->first();
                                            ?>
                                            <a href="#" class="img pull-left">
                                                <img src="{{asset(isset($ldp->thumbnail)?$ldp->thumbnail:'adminux/img/course-df-thumbnail.jpg')}}">
                                                <i class="fas fa-file-image"></i>
                                            </a>
                                            <div class="overflow">
                                                <h4 class="name"><a href="#">{{ $question->getcourse->name }}</a></h4>
                                            </div>
                                        </div>
                                        <div class="comment-course">
                                            <div class="main-comment-course">
                                                <div class="list-comment">
                                                    <div class="left">
                                                        <a href="#" class="img pull-left img-circle">
                                                            <img src="{{asset(isset($question->owner->thumbnail)?$question->owner->thumbnail:'')}}" alt="" width="" height="">
                                                        </a>
                                                        <div class="overflow content">
                                                            <div class="top clearfix">
                                                                <h4 class="name pull-left"><a href="#">{{ $question->owner->first_name }}</a></h4>
                                                                <span class="overflow">{{ time_elapsed_string($question->created_at) }} <i class="fab fa-font-awesome-flag"></i> </span>
                                                            </div>
                                                            <div class="des">
                                                                <p class="des-top">{{ $question->title }}</p>
                                                                <p>{!! $question->content !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="right editor">
                                                        <div class="right-editor">
                                                            <a href="javascript:void(0)" class="icon-exclamation"><i class="fas fa-ellipsis-v"></i></a>
                                                            <div class="link box-dropdown">
                                                                <div class="form-dropdown form-dropdown-top-right">
                                                                    <div class="list">
                                                                        <a href="{{ route('front.users.change_read.post',['id'=>$question->id]) }}">
                                                                            <p class="overflow">{{ $question->readed==1?'Bỏ đánh dấu chưa đọc':'Đánh dấu chưa đọc' }}</p>
                                                                        </a>
                                                                    </div>
                                                                    {{--<div class="list">--}}
                                                                        {{--<a href="#">--}}
                                                                            {{--<p class="overflow">Hủy theo dõi các phản hồi</p>--}}
                                                                        {{--</a>--}}
                                                                    {{--</div>--}}
                                                                    <div class="list">
                                                                        <a href="{{ route('front.users.delete_question.post',['id'=>$question->id]) }}" onclick="return confirm('Are you sure?')">
                                                                            <p class="overflow">Xóa bỏ</p>
                                                                        </a>
                                                                    </div>
                                                                    {{--<div class="list">--}}
                                                                        {{--<a href="#">--}}
                                                                            {{--<p class="overflow">Báo cáo lạm dụng</p>--}}
                                                                        {{--</a>--}}
                                                                    {{--</div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="comment-child">
                                                    <?php
                                                    foreach($question->getAnswer as $answer):
                                                    $usr = Users::whereKey($answer->author)->first();
                                                    ?>
                                                    <div class="list-comment">
                                                        <div class="left">
                                                            <a href="#" class="img pull-left img-circle">
                                                                <img src="{{asset(isset($usr->thumbnail)?$usr->thumbnail:'adminux/img/course-df-thumbnail.jpg')}}" alt="" width="" height="">
                                                            </a>
                                                            <div class="overflow content">
                                                                <div class="top clearfix">
                                                                    <h4 class="name pull-left"><a href="#">{{ $usr->first_name }}</a></h4>
                                                                    <span class="overflow">- Giảng viên  .{{ time_elapsed_string($answer->created_at) }}<i class="fab fa-font-awesome-flag"></i> </span>
                                                                </div>
                                                                <div class="des">
                                                                    {!! $answer->content !!}
                                                                </div>
                                                                <a href="{{ route('front.users.change_usefull.post',['id'=>$answer->id]) }}" class="tick">{{ $answer->usefull==1?'Bỏ đánh dấu trả lời hàng đầu':'Đánh dấu trả lời hàng đầu' }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="right editor">
                                                            <div class="right-editor">
                                                                <a href="javascript:void(0)" class="icon-exclamation"><i class="fas fa-ellipsis-v"></i></a>
                                                                <div class="link box-dropdown">
                                                                    <div class="form-dropdown form-dropdown-top-right">
                                                                        <div class="list">
                                                                            <a href="{{ route('front.users.delete_answerq.post',['id'=>$answer->id]) }}" onclick="return confirm('Are you sure?')">
                                                                                <p class="overflow">Xóa bỏ</p>
                                                                            </a>
                                                                        </div>
                                                                        <div class="list">
                                                                            <a href="#">
                                                                                <p class="overflow">Báo cáo lạm dụng</p>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="top-comment-course">
                                                <form class="box-form-default" enctype="multipart/form-data" method="post" action="{{ route('front.users.reply_question.post') }}">
                                                    {{ csrf_field() }}
                                                    <div class="content">
                                                        <form class="box-form-default">
                                                            <div class="editor">
                                                                <div class="left-editor">
                                                                    <textarea name="content" class="input-form"></textarea>
                                                                </div>
                                                                <div class="submit-comment">
                                                                    <input type="hidden" name="id" value="{{ $question->id }}">
                                                                    <button type="submit" class="btn btn-default-yellow">Thêm câu trả lời</button>
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


                                <div class="box-paging">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            {{ $questions->appends($_GET)->render() }}
                                        </div>
                                    </div>
                                </div>
                                <!--box-paging-->
                            </div>
                        </div>
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