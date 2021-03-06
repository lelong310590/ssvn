@extends('nqadmin-dashboard::frontend.master')

@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/bootstrap-maxlength.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js-init')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/init.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/init.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-maxlength/src/init.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap-tagsinput/src/init.js')}}"></script>

    <script type="text/javascript">
        "use strict";
        $('.editor').ckeditor
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
    <div class="wrapper-content">
        <form method="post" action="{{route('front.khoahoclandingpage.post', $course->id)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" value="{{$course->id}}" name="course_id">
            <div class="container">
                <div class="row course-title align-items-center justify-content-between">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 page-title"><h3><i class="far fa-sitemap "></i> {{$course->name}}</h3></div>
                    <div class="col-sm-3 text-right">
                        <h3>
                            <button type="submit" class="btn btn-primary float-right course-button">L??u l???i</button>
                            <a href="" class="btn btn-primary float-right course-button">Xem tr?????c</a>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Th??m Kh??a ????o t???o</h5>
                            </div>
                            <div class="card-body">
                                <div class="sidebar-course-nav">
                                    @include('nqadmin-course::frontend.course.partials.sidebar')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        <div class="card">
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    @foreach($errors->all() as $e)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                            <strong>L???i!</strong> {{$e}}
                                        </div>
                                    @endforeach
                                @endif

                                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}

                                {{csrf_field()}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-control-label"><b>Ti??u ????? Kh??a ????o t???o</b></label>
                                        <input type="text"
                                               class="form-control input-max-length"
                                               autocomplete="off"
                                               name="name"
                                               value="{{$course->name}}"
                                               maxlength="60"
                                               required
                                               id="input_name"
                                               onkeyup="ChangeToSlug();"
                                        >
                                    </div>

                                    <input type="hidden"
                                           required
                                           parsley-trigger="change"
                                           class="form-control"
                                           autocomplete="off"
                                           name="slug"
                                           value="{{$course->slug}}"
                                           id="input_slug"
                                    >

                                    <div class="form-group">
                                        <label class="form-control-label"><b>Mi??u t??? ng???n</b></label>
                                        <textarea
                                                class="form-control"
                                                name="excerpt"
                                                required
                                                parsley-trigger="change"
                                                maxlength="200"
                                        >{{!empty($ldp) ? $ldp->excerpt : old('excerpt')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label"><b>N???i dung</b></label>
                                        <textarea
                                                class="form-control ckeditor"
                                                name="description"
                                                required
                                                parsley-trigger="change"
                                        >
                                            {{!empty($ldp) ? $ldp->description : old('description')}}
                                        </textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="form-control-label"><b>Ch???ng ch??? cho kh??a ????o t???o</b></label>
                                                <select class="select2 form-control" name="subject" id="select2">
                                                    @if (!empty($ldp))
                                                        @foreach($subjects as $s)
                                                            <option value="{{$s->id}}" {{ ($ldp->subject == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($subjects as $s)
                                                            <option value="{{$s->id}}" {{ (old('subject') == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="form-control-label"><b>Kh??a ????o t???o thu???c v??? c??ng ty</b></label>
                                                <select class="select2 form-control" name="classlevel">
                                                    <option value="">T???t c??? c??c c??ng ty</option>
                                                    @if (!empty($ldp))
                                                        @foreach($classLevels as $s)
                                                            <option value="{{$s->id}}" {{ ($ldp->classlevel == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($classLevels as $s)
                                                            <option value="{{$s->id}}" {{ (old('classlevel') == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label class="form-control-label"><b>Kh??a ????o t???o thu???c tr??nh ?????</b></label>
                                                <select class="select2 form-control" name="level">
                                                    @if (!empty($ldp))
                                                        @foreach($level as $s)
                                                            <option value="{{$s->id}}" {{ ($ldp->level == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($level as $s)
                                                            <option value="{{$s->id}}" {{ (old('level') == $s->id) ? 'selected' : '' }}>{{$s->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Ch??? ????? <b>ch??nh</b> trong Kh??a ????o t???o</label>
                                        <small class="form-text text-muted">
                                            M???i ch??? ????? ???????c ch???n s??? m?? t??? m???t c??ch to??n di???n n???i dung c???a Kh??a ????o t???o m?? kh??ng qu?? r???ng.
                                            V?? d???. "S??n Tennis ho??n ch???nh" n??n c?? "Tennis" ch??? kh??ng ph???i "Tennis Serve" (c??? th???, nh??ng kh??ng to??n di???n)
                                            ch??? kh??ng ph???i "Th??? thao" (to??n di???n, nh??ng kh??ng c??? th???). M???i ch??? ????? c??ch nhau b???i d???u ,
                                        </small>
                                        <br>
                                        <input type="text" class="form-control input-seo-keyword" autocomplete="off" name="tags" value="<?php echo join(',', $tags); ?>" id="tags">
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><b>???nh ?????i di???n Kh??a ????o t???o</b></label>
                                        </div>
                                        <div class="col-sm-4">
                                            <img src="{{ isset($ldp->thumbnail)?asset($ldp->thumbnail):asset('adminux/img/course-df-thumbnail.jpg') }}" id="image_khoa_hoc" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="col-sm-16">
                                                <p>L??m cho s??n kh???u c???a b???n n???i b???t v???i m???t h??nh ???nh tuy???t v???i t??? ?????i ng?? thi???t k??? c???a ch??ng t??i d???a tr??n s??? th??ch v?? phong c??ch c???a b???n. Nh???n h??nh ???nh mi???n ph?? c???a b???n.</p>
                                                <p>N???u b???n t???o ra h??nh ???nh c???a m??nh, n?? ph???i ????p ???ng c??c ti??u chu???n ch???t l?????ng h??nh ???nh c???a Kh??a ????o t???o c???a ch??ng t??i ????? ???????c ch???p nh???n.</p>
                                                <p>Nguy??n t???c quan tr???ng: 750x422 pixel; .jpg, .jpeg ,. gif, ho???c .png. kh??ng c?? v??n b???n tr??n h??nh ???nh.</p>
                                            </div>

                                            <div class="card-body">
                                                <label class="custom-file">
                                                    <input type="file" id="image_khoa_hoc_file" class="custom-file-input" name="thumbnail">
                                                    <span class="custom-file-control"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><b>Phim qu???ng c??o</b></label>
                                        </div>
                                        <div class="col-sm-4">
                                            @if(isset($ldp->video_promo))
                                                <video width="100%" controls>
                                                    <source src="{{asset($ldp->video_promo)}}" type="video/mp4">
                                                </video>
                                            @else
                                                <img src="{{asset('adminux/img/video-placeholder.png')}}" alt="" class="img-fluid" style="width: 100%">
                                            @endif
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="col-sm-16">
                                                <p>H???c sinh xem m???t video qu???ng c??o ???????c t???o ra l?? 5X nhi???u kh??? n??ng ghi danh v??o Kh??a ????o t???o c???a b???n. </p>
                                                <p>Ch??ng t??i ???? th???y r???ng th???ng k?? t??ng l??n ?????n 10X cho nh???ng video tuy???t v???i ?????c bi???t.</p>
                                                <p>T??m hi???u l??m th??? n??o ????? l??m cho b???n awesome!</p>
                                            </div>

                                            <div class="card-body">
                                                <label class="custom-file">
                                                    <input type="file" id="file" class="custom-file-input" name="video_promo">
                                                    <span class="custom-file-control"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('adminux/js/typeahead.js')}}"></script>
    <script>
        $("#image_khoa_hoc_file").change(function () {
            var val = $(this).val().toLowerCase(),
                regex = new RegExp("(.*?)\.(jpg|jpeg|gif|png)$");

            if (!(regex.test(val))) {
                $(this).val('');
                alert('Please select correct file format');
            } else {
                var fr = new FileReader;
                var f = 0;
                fr.onload = function (e) { // file is loaded
                    var img = new Image;

                    img.onload = function () {
                        if (img.height >= 422 && img.width >= 750) {
                            $('#image_khoa_hoc').attr('src', e.target.result);
                        } else {
                            $(this).val('');
                            alert('Chi???u cao t???i thi???u 422px, chi???u r???ng t???i thi???u 750px');
                        }
                    };

                    img.src = fr.result; // is the data URL because called with readAsDataURL
                };
                fr.readAsDataURL(this.files[0]);
            }
        });

        var citynames = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{ route("nqadmin::course.tags.get") }}',
                filter: function (list) {
                    return $.map(list, function (cityname) {
                        return {name: cityname};
                    });
                }
            }
        });
        citynames.initialize();

        $('#tags').tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter(),
            },
            confirmKeys: [13, 188]
        });

        $('.bootstrap-tagsinput').on('keypress', function (e) {
            if (e.keyCode == 13) {
                e.keyCode = 188;
                e.preventDefault();
            }
            ;
        });

    </script>
@endpush