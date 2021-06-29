@extends('nqadmin-dashboard::frontend.master')

@section('content')

<div class="wrapper-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-sm-push-3 order-first create-lesson">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Tạo Khóa đào tạo</h5>
                    </div>
                    <div class="card-body">

                        <form method="post">

                            {{csrf_field()}}
                            <input type="hidden" value="{{Auth::id()}}" name="author">

                            <div class="form-group">
                                <label class="form-control-label">Tất cả bạn cần làm là nhập một tiêu đề làm việc:</label>
                                <input type="text"
                                       required
                                       parsley-trigger="change"
                                       class="form-control input-max-length"
                                       autocomplete="off"
                                       name="name"
                                       value="{{old('name')}}"
                                       id="input_name"
                                       onkeyup="ChangeToSlug();"
                                       maxlength="80"
                                >
                            </div>

                            <input type="hidden"
                                   required
                                   parsley-trigger="change"
                                   class="form-control"
                                   autocomplete="off"
                                   name="slug"
                                   value="{{old('slug')}}"
                                   id="input_slug"
                            >

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary center-block">Lưu và tiếp tục</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script type="text/javascript">
        // convert text to slug
        function ChangeToSlug() {
            var title, slug, seo_title;

            //Lấy text từ thẻ input title
            title = document.getElementById("input_name").value;
            //Đổi chữ hoa thành chữ thường
            slug = title.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”

            if ($('#input-seo-title').length > 0) {
                seo_title = $('#input-seo-title');
                seo_title.val(title);
            }

            document.getElementById('input_slug').value = slug;

            //$("#sortable").sortable();
        }
    </script>
@endpush

