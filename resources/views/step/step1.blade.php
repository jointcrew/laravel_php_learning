@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">@lang('change_year.title')</div>
                <div class="card-body">
                    <form class="" action="/changeYear" method="post">
                        <!-- CSRF保護 -->
                        @csrf

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
