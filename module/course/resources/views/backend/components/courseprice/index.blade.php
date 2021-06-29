@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/moment/min/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/js/init.js')}}"></script>
    <script src="https://cdn.tiny.cloud/1/1mkudqklng9crolevl4317aes2au2e24j1zzu6z1oq8excw7/tinymce/4.9.11-104/tinymce.min.js"></script>
    <script>
        $('#datetimepicker').datetimepicker({
            'sideBySide': true,
            format: 'DD/MM/YYYY HH:mm'
        });
        $('#create_coupon').click(function () {
            var magiamgia = $("#magiamgia").val().toUpperCase();
            var hethan = $("#hethan").val();
            var soluong = $("#soluong").val();
            var patt = new RegExp("^[A-Z0-9\\_\\-\\.]{6,20}$");
            if (patt.test(magiamgia)) {
                $("#create_coupon_form").submit();
            } else {
                alert('Mã giảm giá chưa đúng định dạng.');
            }
        })

        $('.change-price').change(function () {
            var name = $(this).attr('rel');
            $('input[name=' + name + ']').val($(this).val());
        })

        function changeStatus(id) {
            $.ajax({
                type: "POST",
                url: '{{ route("nqadmin::coupon.changestt.post") }}',
                data: "_token={{ csrf_token() }}&id=" + id,
                dataType: 'json',
                beforeSend: function () {
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //console.log(xhr.responseText)
                },
                success: function (data) {

                }
            });
        }

        function showMd(slug, code) {
            var url = slug + '?couponCode=' + code;
            $("#linkgiamggia").val(url);
            $('#exampleModal').modal().show();
            $('.modal-backdrop').hide();
        }
    </script>
@endpush

<div class="card-body">
    <h6>Giá Khóa đào tạo</h6>
    <p>Vui lòng chọn mức giá cho Khóa đào tạo của bạn bên dưới và nhấp vào 'Lưu'.</p>
    <br>
    <div class="form-group">
        <label for="">Chọn tầng giá cho Khóa đào tạo</label>
        <select class="form-control change-price" rel="price">
            <option value="0">Chọn tầng giá</option>
            @foreach($priceTier as $tier)
                <option value="{{ $tier->price }}" {{ $course->price == $tier->price?'selected':'' }}>
                    {{ $tier->price==0?'Miễn phí':number_format($tier->price).' VNĐ' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="">Tự động tham gia chương trình giảm giá của hệ thống</label>
        <select class="form-control change-price" rel="approve_sale_system">
            <option value="active" {{$course->approve_sale_system == 'active' ? 'selected' : ''}}>Đồng ý</option>
            <option value="disable" {{$course->approve_sale_system == 'disable' ? 'selected' : ''}}>Từ chối</option>
        </select>
    </div>
    <br>
    <br>
    <br>
    <h6>Mã giảm giá Khóa đào tạo</h6>
    <div class="row" id="search_form">
        <div class="col-md-6">
            <button class="btn btn-default" onclick="$('#search_form').hide();$('#create_form').show();">Tạo mã giảm giá mới</button>
        </div>
        <div class="col-md-10 text-right">
            <form class="form-inline pull-right" method="get" action="">
                <div class="form-group mr-sm-2">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="disable" {{ (isset($_REQUEST['disable']))?'checked':'' }}>
                        <span class="custom-control-indicator"></span> <span class="custom-control-description">Hiển thị toàn bộ mã giảm giá</span> </label>
                </div>
                <div class="form-group mr-sm-2">
                    <input name="q" placeholder="Tìm kiếm mã" class="form-control" value="{{ isset($_REQUEST['q'])?$_REQUEST['q']:'' }}">
                </div>
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-16" id="create_form" style="display: none;">
            <a href="#" onclick="$('#create_form').hide();$('#search_form').show();return false;">Hủy tạo mã giảm giá</a>
            <p>
                Mã phiếu giảm giá của bạn phải có từ 6 đến 20 ký tự. Nó chỉ có thể chứa các ký tự chữ và số (A-Z, 0-9), dấu chấm ("."), Dấu gạch ngang ("-") hoặc dấu gạch dưới ("_"). Tất cả các chữ
                cái đều phải VIẾT HOA.
            </p>
            <div class="row">
                <div class="col-md-8">
                    <form method="post" id="create_coupon_form" action="{{ route('nqadmin::coupon.create.post') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input style="text-transform: uppercase;" type="text" class="form-control" id="magiamgia" name="code" placeholder="Mã giảm giá">
                        </div>
                        <fieldset class="form-group">
                            <p>Chọn kiểu giảm giá</p>
                            <div class="form-group">
                                <input onclick="$('#pr').hide();" type="radio" class="form-check-input" name="type" id="optionsRadios1" value="0" checked style="margin-left: 0">
                                Miễn phí
                            </div>
                            <div class="form-group">
                                <input onclick="$('#pr').show();" type="radio" class="form-check-input" name="type" id="optionsRadios2" value="1" style="margin-left: 0">
                                Chiết khấu
                            </div>
                        </fieldset>
                        <div class="form-group" id="pr" style="display: none;">
					<span class="input-group">
						<span class="input-group-addon">VNĐ</span>
						<input type="number" step="1" min="0" name="price" placeholder="$ Discounted price" required="" value="{{ $course->price?$course->price:0 }}" id="price-field"
                               class="create-coupon-form--decimal-price-field--1dqdI form-control">
						</span></div>
                        <div class="form-group">
                            <input name="reamain" type="number" id="soluong" class="form-control" placeholder="Số lượng phát hành" required>
                        </div>
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker'>
                                <input id="hethan" type='text' class="form-control input-group-addon" name="deadline" value="" style="text-align: left" placeholder="Ngày hết hạn" required/>
                            </div>
                        </div>
                        <input type="hidden" name="course" value="{{ $course->id }}">
                        <button type="button" id="create_coupon" class="btn btn-primary">Tạo giảm giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-16">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>CODE</th>
                        <th>Link</th>
                        <th>Giá</th>
                        <th>Còn lại</th>
                        <th>Ngày tạo</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupon as $c)
                        <tr>
                            <td>{{ strtoupper($c->code) }}</td>
                            <td><a href="#" onclick="showMd('{{ route('front.course.buy.get',['slug'=>$course->slug]) }}','{{ $c->code }}');return false;">Lấy Link</a></td>
                            <td>{{ number_format($c->price) }}</td>
                            <td>{{ $c->reamain }}</td>
                            <td>{{ date('d/m/Y H:i',strtotime($c->created_at)) }}</td>
                            <td>{{ date('d/m/Y H:i',strtotime($c->deadline)) }}</td>
                            <td>
                                <div class="can-toggle demo-rebrand-2 small">
                                    <input onchange="changeStatus({{ $c->id }});" id="{{ $c->id }}" type="checkbox" <?php if ($c->status == 'active') {
                                        echo 'checked';
                                    }?>>
                                    <label for="{{ $c->id }}">
                                        <div class="can-toggle__switch" data-checked="On" data-unchecked="Off"></div>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $coupon->appends($_GET)->render() }}
            </div>
        </div>
    </div>
</div>
<div class="modal dark_bg fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:9999;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Link giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="linkgiamggia">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>