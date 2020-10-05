@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">step</div>
                <div class="card-body">
                    @include('layouts.step')
                    <div class="form-group row">
                        <div class="col-md-3 mt-3">
                            <a class="btn btn-outline-primary" href="/step2">@lang('common.back')</a>
                        </div>
                        <div class="col-md-3 mt-3">
                            <a class="btn btn-primary" href="/step4">@lang('common.next')</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
