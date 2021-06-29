@section('js')
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminux/vendor/select2/dist/js/i18n/vi.js')}}"></script>
    <script>
        $("#data").select2({
            placeholder: "Nhập tên người dùng",
            allowClear: true,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "{{ route('front.message.search.user') }}",
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
            $('#user_id').val($(this).val());
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
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminux/vendor/select2/dist/css/select2-bootstrap.min.css')}}">
@endsection
@if(empty($chat_user))
    <div class="form-group">
        <select class="form-control" id="data">

        </select>
    </div>
@endif
<input type="hidden" id="user_id" name="user_id" value="{{ !empty($chat_user)?$chat_user->id:'' }}">