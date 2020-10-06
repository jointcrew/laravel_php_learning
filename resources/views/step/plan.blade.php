@extends('layouts.app')
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script src=" js/plan.js?<?= strtotime('now') ?> " defer></script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">プラン一覧</div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="tbl1">
                        <thead>
                            <tr>
                                <th>@lang('step.id')</th>
                                <th>@lang('step.plan_name')</th>
                                <th>@lang('step.plan_fee')</th>
                                <th>@lang('step.description')</th>
                            </tr>
                        </thead>
                        @foreach ($datalist as $data)
                            <tr id="rowNo{{$data["id"]}}">
                                <td>{{$data["id"]}}</td>
                                <td>{{$data["plan_name"]}}</td>
                                <td>{{$data["plan_fee"]}}</td>
                                <td>{{$data["description"]}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">プラン登録</div>
                <div class="card-body">
                    <!--登録-->
                    <div class="row  m-4">
                        <div class="col-md-1">
                            @lang('unit_test.register')
                        </div>
                        <div class="col-md-9">
                            <div class='row col-md-12 mb-2'>
                                <!-- プラン名 -->
                                <div class='col-md-3'>
                                    @lang('step.plan_name')
                                </div>
                                <div class='col-md-9'>
                                    <input id='plan_name' type="text" class="form-control" name="plan_name" value="{{ old('plan_name') }}">
                                </div>
                            </div>
                            <div class='row col-md-12 mb-2'>
                                <div class='col-md-3'>
                                    <!-- プラン料金 -->
                                    @lang('step.plan_fee')
                                </div>
                                <div class='col-md-9'>
                                    <input id='plan_fee' type="number" class="form-control" name="plan_fee" value="{{ old('plan_fee') }}">
                                </div>
                            </div>
                            <div class='row col-md-12 mb-2'>
                                <div class='col-md-3'>
                                    <!-- 説明 -->
                                    @lang('step.description')
                                </div>
                                <div class='col-md-9'>
                                    <input id='description' type="text" class="form-control" name="description" value="{{ old('description') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mt-5">
                            <a id='regist' class="btn btn-success">@lang('unit_test.register')</a>
                        </div>
                    </div>
                    <div class="row  m-4">
                        <div class="col-md-1">
                            @lang('step.delete')
                        </div>
                        <div class="col-md-9">
                            <div class='row col-md-12 mb-2'>
                                <!-- プラン名 -->
                                <div class='col-md-3'>
                                    @lang('step.id')
                                </div>
                                <div class='col-md-9'>
                                    <input id='id' type="text" class="form-control" name="id" value="{{ old('id') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a id='delete' class="btn btn-success">@lang('unit_test.register')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
