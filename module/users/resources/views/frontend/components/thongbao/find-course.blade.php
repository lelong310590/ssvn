@push('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
    <script>
        $("#data").select2({
            placeholder: "Tìm kiếm các Khóa đào tạođủ điều kiện",
            allowClear: true,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "{{ route('front.user.search.course') }}",
                method: "POST",
                dataType: 'json',
                cache: true,
                delay: 100,
                data: function (term, page) {
                    return {
                        q: term, // search term
                        page_limit: 10,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    };
                },
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 2,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        }).change(function () {
            var value = $('#input-list-course').val().split(",");
            if (value.indexOf($(this).val()) == -1) {
                value.push($(this).val());
                $('#input-list-course').val(value.join(','));

                $('.form-select-course .close-select').removeClass('hidden');
                var string = '<li class="pull-left">\n' +
                    '            <span>' + $(this).text() + ' <i class="far fa-times-circle"></i></span>\n' +
                    '        </li>';
                $('#list-course').append(string);
            }
            $(this).text('');
        });

        function formatRepoSelection(repo) {
            return repo.text;
        }

        function formatRepo(repo) {
            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.text + " </div></div>";

            return markup;
        }

        $('.form-select-course .close-select').click(function () {
            $(this).parent().parent().find('.content ul li').remove();
            $(this).addClass('hidden');
            $('#input-list-course').val('');
        });
        $("#select_all").click(function () {
            var $this = $(this);
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: "{{ route('front.user.search.allcourse') }}",
                data: {_token: '{{csrf_token()}}'},
                dataType: 'json', // what type of data do we expect back from the server
                error: function (data) {

                },
                success: function (data) {
                    if (data.length > 0) {
                        $this.parent().parent().find('.content ul li').remove();
                        $('#input-list-course').val('');

                        var value = $('#input-list-course').val().split(",");
                        for (var k in data) {
                            var string = '<li class="pull-left">\n' +
                                '            <span>' + data[k].name + ' <i class="far fa-times-circle"></i></span>\n' +
                                '        </li>';
                            $('#list-course').append(string);
                            value.push(data[k].id);
                        }
                        $('#input-list-course').val(value.join(','));
                        $('.form-select-course .close-select').removeClass('hidden').show();
                    }
                }
            })
        })
    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endpush
<div class="top">
    <a href="javascript:void(0)" id="select_all" class="text-select ">Chọn tất cả các Khóa đào tạocó đủ điều kiện</a>
    <a href="javascript:void(0)" class="close-select hidden">Xóa các lựa chọn</a>
</div>
<div class="content">
    <ul class="clearfix" id="list-course">
    </ul>

    <input type="hidden" name="courses" id="input-list-course">
    <div class="search form-group">
        <select class="form-control" id="data">

        </select>
    </div>

</div>