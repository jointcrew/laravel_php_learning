@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">step</div>
                <div class="card-body">
                    @include('layouts.step')
                    <div class="row">
                        <div class="col-md-3 m-4">
                            名前：
                            @if (isset($name))
                                {{$name}}
                            @endif
                        </div>
                        <div class="col-md-5 m-4">
                            PDF表示時間：
                            @if (isset($disply_date))
                            {{$disply_date}}
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-3 m-2">
                            選択保険プラン
                        </div>
                        <div class="col-md-5 m-3">
                            @foreach($insurance as $key => $value)
                                @if ($key == $plan_name)
                                    {{$value}}
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-5 m-3">
                            料金：{{$plan_fee}}円
                        </div>
                        <div class="col-md-5 ml-3 mb-1">
                            説明
                        </div>
                        <div class="col-md-5 ml-3 mt-1">
                            {{$description}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <a class="btn btn-outline-primary" href="/step3">@lang('common.back')</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary" href="/step5">完了</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
