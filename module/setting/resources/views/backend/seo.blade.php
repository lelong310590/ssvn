@extends('nqadmin-dashboard::backend.master')

@push('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/ckeditor/ckeditor.js')}}"></script>
@endpush

@section('content')
    <div class="wrapper-content">
        <div class="container">
            <div class="row  align-items-center justify-content-between">
                <div class="col-11 col-sm-12 page-title">
                    <h3><i class="fa fa-sitemap "></i> Cấu hình chung</h3>
                    <p>Cấu hình SEO</p>
                </div>
            </div>

            <form method="post">
                @if (count($errors) > 0)
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <strong>Lỗi!</strong> {{$e}}
                        </div>
                    @endforeach
                @endif

                {!! \Base\Supports\FlashMessage::renderMessage('edit') !!}

                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">SEO</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Tagline hệ thống</label>
                                    <small class="form-text text-muted">Tagline</small>
                                    <input type="text"
                                           class="form-control input-max-length"
                                           autocomplete="off"
                                           name="seo_tagline"
                                           value="{{!empty($seo_tagline) ? $seo_tagline->content : ''}}"
                                           id="input-seo-title"
                                           maxlength="80"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo title trang chủ</label>
                                    <small class="form-text text-muted">Seo title nên dưới 80 ký tự</small>
                                    <input type="text"
                                           class="form-control input-max-length"
                                           autocomplete="off"
                                           name="seo_title"
                                           value="{{!empty($seo_title) ? $seo_title->content : ''}}"
                                           id="input-seo-title"
                                           maxlength="80"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo keyword trang chủ</label>
                                    <small class="form-text text-muted">Mỗi từ khóa cách nhau bởi dấu ,. Tối đa 5 từ khóa </small>
                                    <input type="text"
                                           class="form-control input-seo-keyword"
                                           autocomplete="off"
                                           name="seo_keywords"
                                           value="{{!empty($seo_keywords) ? $seo_keywords->content : ''}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Seo description trang chủ</label>
                                    <small class="form-text text-muted">Seo description nên dưới 160 ký tự</small>
                                    <textarea class="form-control input-max-length"
                                              rows="3"
                                              name="seo_description"
                                              value="{{$seo_description}}"
                                              maxlength="160"
                                    >{{!empty($seo_description) ? $seo_description->content: ''}}</textarea>
                                </div>
                                {{--<div class="form-group">--}}
                                {{--<label class="form-control-label">URL</label>--}}
                                {{--<input type="text" name="url" value="" class="form-control">--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Thao tác</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Lưu lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection