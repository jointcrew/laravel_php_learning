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
                    <form class="" action="/step2" method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group row">
                            <div class="col-xs-2 mt-3 ml-3">
                                名前：
                            </div>
                            <div class="col-md-3 mt-3">
                                @if (!($name == null))
                                    @foreach ($name as $name_)
                                        <input type="text" name="name" class="form-control" value="{{$name_}}">
                                    @endforeach
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
                                <select name='type' class="form-control" id="select_type">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
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
