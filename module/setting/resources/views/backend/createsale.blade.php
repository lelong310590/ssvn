@extends('nqadmin-dashboard::backend.master')

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
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/bootstrap4-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> C???u h??nh gi???m gi??</h3>
                    <p>T???o m???i gi???m gi??</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-8 order-first">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">T???o gi???m gi??</h5>
                        </div>
                        <div class="card-body">

                            <form method="post" action="{{ route('nqadmin::setting.createsale.post') }}">
                                {{ csrf_field() }}
                                @if (count($errors) > 0)
                                    @foreach($errors->all() as $e)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>L???i!</strong> {{$e}}
                                        </div>
                                    @endforeach
                                @endif

                                {{csrf_field()}}
                                <input type="hidden" value="{{Auth::id()}}" name="author">

                                <div class="form-group">
                                    <label class="form-control-label">T??n:</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">??p d???ng cho Kh??a ????o t???ogi?? trong kho???ng t???:</label>
                                    <input type="number" name="min_price" class="form-control" placeholder="gi?? t???" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">??p d???ng cho Kh??a ????o t???ogi?? trong kho???ng t???i:</label>
                                    <input type="number" name="max_price" class="form-control" placeholder="gi?? t???i" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Gi?? ??p d???ng:</label>
                                    <input type="number" name="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Ng??y b???t ?????u</label>
                                    <input type="text" name="start_time" class="form-control picker">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Ng??y k???t th??c</label>
                                    <input type="text" name="end_time" class="form-control picker">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary float-right">T???o m???i</button>
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
    <script>
        $('.picker').datetimepicker({
            // 'autoclose': true
        });
    </script>
@endpush