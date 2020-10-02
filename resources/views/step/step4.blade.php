@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">step</div>
                <div class="card-body">
                    <div id="estimate_block" class="step-<?=$step?>">
                        <div class="box-step">
                            <ul class="list-step clearfix">
                                <li>
                                    <div class="step-1"></div>
                                </li>
                                <li>
                                    <div class="step-2"></div>
                                </li>
                                <li>
                                    <div class="step-3"></div>
                                </li>
                                <li>
                                    <div class="step-4"></div>
                                </li>
                            </ul>
                        </div>
                        <ul class="list-step clearfix">
                            <li class="<?= ($step === 1)? 'active' : ''; ?>">
                                <p>@lang('step.0000012')</p> <!--お客さま情報入力 -->
                            </li>
                            <li class="<?= ($step === 2)? 'active' : ''; ?>">
                                <p>@lang('step.0000013')</p><!--重要事項確認 -->
                            </li>
                            <li class="<?= ($step === 3)? 'active' : ''; ?>">
                                <p>@lang('step.0000014')</p><!--告知入力 -->
                            </li>
                            <li class="<?= ($step === 4)? 'active' : ''; ?>">
                                <p>@lang('step.0000015')</p><!--お申込み内容・意向確認 -->
                            </li>
                        </ul>
                    </div>
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
                        <div class="col-md-3">
                            <a class="btn btn-outline-primary" href="/step3">@lang('common.back')</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
