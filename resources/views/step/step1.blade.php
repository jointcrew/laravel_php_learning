@extends('layouts.app')
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script src=" js/step.js?<?= strtotime('now') ?> " defer></script>
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
                    <form class="" action="/step2" method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group row">
                            <div class="col-xs-2 mt-3 ml-3">
                                名前：
                            </div>
                            <div class="col-md-3 mt-3 ml-5">
                                @if (!($name == null))
                                    <input type="text" name="name" class="form-control" value="{{$name}}">
                                    @if ($errors->has('name'))
                                        <br><span class="red">{{ $errors->first('name')}}</span>
                                    @endif
                                @else
                                    <input type="text" name="name" class="form-control" value=''>
                                    @if ($errors->has('name'))
                                        <br><span class="red">{{ $errors->first('name')}}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2 mt-3 ml-3">
                                プラン選択：
                            </div>
                            <div class="col-md-3 mt-3">
                                <select name='plan_type' class="form-control" id="plan_type">
                                    @foreach($insurance as $key => $value)
                                        @if (!($plan_name == null))
                                            @if ($plan_name == $key)
                                            <option selected name="category" value={{$key}}>{{$value}}</option>
                                            @else
                                            <option  name="category" value={{$key}}>{{$value}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('plan_type'))
                                    <br><span class="red">@lang('validation.plan_type')</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2 mt-3 ml-3">
                                プラン料金：
                            </div>
                            <div class="col-md-3 mt-3" id="plan_fee">
                                @if (!($plan_name == null))
                                    {{$plan_fee}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2 mt-3 ml-3">
                                プラン説明：
                            </div>
                            <div class="col-md-3 mt-3" id="plan_discription">
                                @if (!($plan_name == null))
                                    {{$description}}
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-3 mt-3">
                            <input type="submit" name="" value="@lang('common.next')" class="btn btn-primary">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
