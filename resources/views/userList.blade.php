@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">@lang('common.search')</div>
                <div class="card-body">
                    <form action="/userApiSearch" method="get">
                        <!-- CSRF保護 -->
                        @csrf
                        <!-- 検索 -->
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value= @lang('common.search')>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">@lang('user.user_add')</div>
                <div class="card-body">
                    <!-- 登録 -->
                    <form action="/userApiRegister" method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group">
                            @lang('user.name')：<span  class="red">@lang('common.required')</span>
                            <input class="form-control" type="text" name="name" size="40"  >
                            @if ($errors->has('name'))
                                <br><span class="red">{{ $errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.email')：<span class="red">@lang('common.required')</span>
                            <input class="form-control" type="text" name="email" size="40"  >
                            @if ($errors->has('email'))
                                <br><span class="red">{{ $errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.only_password')：<span class="red">@lang('common.required')</span>
                            <input class="form-control" id='password' type="password" name="password" size="40" >
                            @if ($errors->has('password'))
                                <br><span class="red">{{ $errors->first('password')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.password_confirmation')：<span class="red">@lang('common.required')</span>
                            <input class="form-control" id='password_confirmation' type="password" name="password_confirmation" size="40" >
                            @if ($errors->has('password_confirmation'))
                                <br><span class="red">{{ $errors->first('password_confirmation')}}</span>
                            @endif
                        </div>
                        <div  class="form-group">
                            @lang('user.role')：<span class="red">@lang('common.required')</span>
                            <select name="role" class="form-control">
                                @foreach($roles as $role)
                                    <option value=1>{{$role["admin"]}}</option>
                                    <option value=5>{{$role["user"]}}</option>
                                @endforeach
                                @if ($errors->has('role'))
                                    <br><span class="red">{{ $errors->first('role')}}</span>
                                @endif
                        </div>
                        <div class="form-group">
                            <input type="submit"  class="btn btn-primary" value=@lang('common.save')>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">@lang('user.user_list')</div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <p class="red">
                            @if (isset($msg))
                                {{$msg}}
                            @endif
                        </p>
                        <thead>
                            <tr>
                                <th>@lang('user.id')</th>
                                <th>@lang('user.name')</th>
                                <th>@lang('user.email')</th>
                                <th>@lang('user.role')</th>
                                <th>@lang('user.created_at')</th>
                                <th>@lang('item.edit_link')</th>
                            </tr>
                        </thead>
                        @if (isset($list[0]))
                            @foreach($list as $user)
                                <tr>
                                    <td>{{$user["id"]}}</td>
                                    <td>{{$user["name"]}}</td>
                                    <td>{{$user["email"]}}</td>
                                    <td>
                                        @if (isset($list[0]))
                                            @lang("user.role_name.{$user['role']}")
                                        @endif
                                    </td>
                                    <td>{{$user["created_at"]}}</td>
                                    <td>
                                        @if (isset($list[0]))
                                            <a href="/userEdit?userId={{$user["id"]}}" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                        @endif
                                        @if ($create_user_id != $user['id'])
                                            <a href="/userDelete?userId={{$user["id"]}}" class="btn btn-danger btn-sm">@lang('item.delete_link')</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
