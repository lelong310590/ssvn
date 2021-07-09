{{csrf_field()}}
<div class="card-body">
    <div class="form-group">
        <label class="form-control-label"><b>Tiêu đề Khóa đào tạo</b></label>
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
        <label class="form-control-label"><b>Miêu tả ngắn</b></label>
        <textarea
                class="form-control"
                name="excerpt"
                required
                parsley-trigger="change"
                maxlength="200"
        >{{!empty($ldp) ? $ldp->excerpt : old('excerpt')}}</textarea>
    </div>

    <div class="form-group">
        <label class="form-control-label"><b>Nội dung</b></label>
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
                <label class="form-control-label"><b>Chứng chỉ cho khóa đào tạo</b></label>
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
                <label class="form-control-label"><b>Khóa đào tạo thuộc về công ty</b></label>
                <select class="select2 form-control" name="classlevel">
                    <option value="">Tất cả các công ty</option>
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
                <label class="form-control-label"><b>Khóa đào tạo thuộc trình độ</b></label>
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
        <label class="form-control-label">Chủ đề <b>chính</b> trong Khóa đào tạo</label>
        <small class="form-text text-muted">
            Mỗi chủ đề được chọn sẽ mô tả một cách toàn diện nội dung của Khóa đào tạo mà không quá rộng.
            Ví dụ. "Sân Tennis hoàn chỉnh" nên có "Tennis" chứ không phải "Tennis Serve" (cụ thể, nhưng không toàn diện)
            chứ không phải "Thể thao" (toàn diện, nhưng không cụ thể). Mỗi chủ đề cách nhau bởi dấu ,
        </small>
        <br>
        <input type="text" class="form-control input-seo-keyword" autocomplete="off" name="tags" value="<?php echo join(',', $tags); ?>" id="tags">
    </div>

    <div class="row">
        <div class="col-sm-16">
            <label class="form-control-label"><b>Ảnh đại diện Khóa đào tạo</b></label>
        </div>
        <div class="col-sm-8">
            <img src="{{ isset($ldp->thumbnail)?asset($ldp->thumbnail):asset('adminux/img/course-df-thumbnail.jpg') }}" id="image_khoa_hoc" alt="" class="img-fluid">
        </div>
        <div class="col-sm-8">
            <div class="col-sm-16">
                <p>Làm cho sân khấu của bạn nổi bật với một hình ảnh tuyệt vời từ đội ngũ thiết kế của chúng tôi dựa trên sở thích và phong cách của bạn. Nhận hình ảnh miễn phí của bạn.</p>
                <p>Nếu bạn tạo ra hình ảnh của mình, nó phải đáp ứng các tiêu chuẩn chất lượng hình ảnh của Khóa đào tạo của chúng tôi để được chấp nhận.</p>
                <p>Nguyên tắc quan trọng: 750x422 pixel; .jpg, .jpeg ,. gif, hoặc .png. không có văn bản trên hình ảnh.</p>
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
        <div class="col-sm-16">
            <label class="form-control-label"><b>Phim quảng cáo</b></label>
        </div>
        <div class="col-sm-8">

            @if($ldp->getOriginal('video_promo') != null)
                @php
                    $convertVideo = str_replace('/index.m3u8', '', $ldp->video_promo);
                @endphp
                <video width="100%" controls>
                    <source src="{{asset($convertVideo)}}" type="video/mp4">
                </video>

                <br>
                <a class="btn btn-xs btn-danger" href="{{route('nqadmin::course.removepromovideo', $ldp->id)}}" style="color: #fff">
                    <i class="fa fa-trash-o "></i> Xoá Video
                </a>
            @else
                <img src="{{asset('adminux/img/video-placeholder.png')}}" alt="" class="img-fluid" style="width: 100%">
            @endif
        </div>
        <div class="col-sm-8">
            <div class="col-sm-16">
                <p>Học sinh xem một video quảng cáo được tạo ra là 5X nhiều khả năng ghi danh vào Khóa đào tạo của bạn. </p>
                <p>Chúng tôi đã thấy rằng thống kê tăng lên đến 10X cho những video tuyệt vời đặc biệt.</p>
                <p>Tìm hiểu làm thế nào để làm cho bạn awesome!</p>
            </div>

            <div class="card-body">
                <p id="video-message"></p>
                <label class="custom-file">
                    <input type="file" id="video_promo" class="custom-file-input" name="video_promo" accept="video/*">
                    <span class="custom-file-control"></span>
                </label>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript" src="{{asset('adminux/js/typeahead.js')}}"></script>
    <script>
        $("#image_khoa_hoc_file").change(function () {
            var val = $(this).val().toLowerCase(),
                regex = new RegExp("(.*?)\.(jpg|jpeg|gif|png)$");

            if (!(regex.test(val))) {
                $(this).val('');
                alert('Xin hãy chọn đúng định dạng ảnh');
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
                            alert('Chiều cao tối thiểu 422px, chiều rộng tối thiểu 750px');
                        }
                    };

                    img.src = fr.result; // is the data URL because called with readAsDataURL
                };
                fr.readAsDataURL(this.files[0]);
            }
        });

        $("#video_promo").change(function (e) {
            var val = $(this).val().toLowerCase(),
                regex = new RegExp("(.*?)\.(mp4)$");

            if (!(regex.test(val))) {
                $(this).val('');
                alert('Xin hãy chọn đúng định dạng Video');
            } else {
                var filename = e.target.files[0].name
                $('#cv-name-value').val(filename);
                $('#video-message').html('Đã chọn video, bấm Lưu lại để đăng');
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
