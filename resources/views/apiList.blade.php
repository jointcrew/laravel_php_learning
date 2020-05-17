@extends('layouts.app')
<script src="{{ asset('js/api.js') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('api.list.title')</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row border-bottom m-4 bg-light">
                                <div class="col-md-1">
                                    @lang('api.list.name')
                                </div>
                                <div class="col-md-10">
                                    @lang('api.list.form')
                                </div>
                                <div class="col-md-1">
                                    @lang('api.list.btm')
                                </div>
                            </div>
                            <!-- 一覧 -->
                            {{ Form::open(['url' => '/api/apiuser', 'method' => 'get', 'name' => 'getForm']) }}
                                <div class="row border-bottom m-4">
                                    <div class="col-md-1">
                                        @lang('api.list.get')
                                    </div>
                                    <div class="col-md-10">
                                        <div class='row col-md-12'>
                                            <!-- id -->
                                            <div class='col-md-1'>
                                                @lang('api.list.id')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::number('get_id', old('get_id'), ['class' => 'form-control', 'id' => 'get_id', 'size' => '4', 'onchange' => 'changeGetUrl();' ])}}
                                                {{Form::hidden('id', "$user->id")}}
                                                {{Form::hidden('name', "$user->name")}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        {{Form::submit(__('api.list.get_btm'), ['class' => 'btn btn-primary btn-sm'])}}
                                    </div>
                                </div>
                            {{Form::close()}}
                            <!-- 登録 -->
                            {{ Form::open(['url' => '/api/apiuser', 'method' => 'post', 'name' => 'postForm']) }}
                                <div class="row border-bottom m-4">
                                    <div class="col-md-1">
                                        @lang('api.list.post')
                                    </div>
                                    <div class="col-md-10">
                                        <div class='row col-md-12'>
                                            <!-- name -->
                                            <div class='col-md-1'>
                                                @lang('api.list.user_name')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::text('user_name', old('user_name'), ['class' => 'form-control'])}}
                                            </div>
                                            <!-- age -->
                                            <div class='col-md-1'>
                                                @lang('api.list.age')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::text('age', old('age'), ['class' => 'form-control'])}}
                                                <!-- hiddenでリクエストパラメーターを返す -->
                                                {{Form::hidden('create_user_id', "$user->id")}}
                                                {{Form::hidden('create_user_name', "$user->name")}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        {{Form::submit(__('api.list.post_btm'), ['class' => 'btn btn-primary btn-sm'])}}
                                    </div>
                                </div>
                            {{Form::close()}}
                            <!-- 編集 -->
                            {{ Form::open(['url' => '/api/apiuser/null', 'method' => 'PUT', 'name' => 'putForm']) }}
                                <div class="row border-bottom m-4">
                                    <div class="col-md-1">
                                        @lang('api.list.put')
                                    </div>
                                    <div class="col-md-10">
                                        <div class='row col-md-12'>
                                            <!-- id -->
                                            <div class='col-md-1'>
                                                @lang('api.list.id')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::number('put_id', old('put_id'), ['class' => 'form-control', 'id' => 'put_id', 'size' => '4', 'onchange' => 'changePutUrl();' ])}}
                                            </div>
                                            <!-- name -->
                                            <div class='col-md-1'>
                                                @lang('api.list.user_name')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::text('user_name', old('user_name'), ['class' => 'form-control'])}}
                                            </div>
                                            <!-- age -->
                                            <div class='col-md-1'>
                                                @lang('api.list.age')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::text('age', old('age'), ['class' => 'form-control'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        {{Form::submit(__('api.list.put_btm'), ['class' => 'btn btn-primary btn-sm'])}}
                                    </div>
                                </div>
                            {{Form::close()}}
                            <!-- 削除 -->
                            {{ Form::open(['url' => '/api/apiuser/null', 'method' => 'DELETE', 'name' => 'deleteForm']) }}
                                <div class="row border-bottom m-4">
                                    <div class="col-md-1">
                                        @lang('api.list.delete')
                                    </div>
                                    <div class="col-md-10">
                                        <div class='row col-md-12'>
                                            <!-- id -->
                                            <div class='col-md-1'>
                                                @lang('api.list.id')
                                            </div>
                                            <div class='col-md-3'>
                                                {{Form::number('delete_id', old('delete_id'), ['class' => 'form-control', 'id' => 'delete_id', 'size' => '4', 'onchange' => 'changeDeleteUrl();' ])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        {{Form::submit(__('api.list.delete_btm'), ['class' => 'btn btn-primary btn-sm'])}}
                                    </div>
                                </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
