@extends('nqadmin-dashboard::frontend.master')

@section('content')
    <div class="main-page">
        <div class="height-full page-message">
            <div class="container">

            @include('nqadmin-messages::frontend.partials.top-messsage')
            <!--top-message-->

                <div class="main-page row">
                    <div class="left-message col-xs-5">
                        <div class="main-left">
                            @include('nqadmin-messages::frontend.partials.option')

                            <div class="box-list-message">
                                @include('nqadmin-messages::frontend.partials.message')
                            </div>

                            <div class="box-btn-message">
                                @include('nqadmin-messages::frontend.partials.create-button')
                            </div>
                        </div>
                    </div>
                    <!--left-message-->

                    <div class="right-message col-xs-7">
                        @if(!empty($user->messages->first()))
                            @php($first_message = empty(request('message_id'))?$user->messages->first():$user->messages->where('message_id',request('message_id'))->first())
                            @include('nqadmin-messages::frontend.components.main-message')
                        @endif
                    </div>
                    <!--right-message-->

                </div>
                <!--main-page-->

            </div>
        </div>
    </div>
    <!--main-page-->
@endsection