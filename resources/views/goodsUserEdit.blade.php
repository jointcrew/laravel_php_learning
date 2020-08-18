@extends('layouts.app')
<script src="{{ asset('js/api_itemuser.js') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">@lang('common.menu.goods_user_edit')</div>
                <div class="card-body">
                    <div class="form-group col-md-5">
                        <a href="/goodsUser">@lang('common.back')</a>
                    </div>
                    <!-- 登録 -->
                    <form action="/goodsUserEdit" method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        @if (isset($data["id"]))
                            <input type="hidden" name="user_id" value={{$data["id"]}}>
                        @endif
                        <div class="form-group">
                            @lang('user.user_name')：<span class="red">@lang('common.required')</span>
                            <input class="form-control" type="text" name="name" size="40"
                            value="<?php old('name')? print old('name'):(isset($data["name"])? print  $data["name"]:'');?>">
                            @if ($errors->has('name'))
                                <br><span class="red">{{ $errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.email')：<span class="red">@lang('common.required')</span>
                            <input class="form-control" type="email" name="email" size="40"
                            value="<?php old('email')? print old('email'):(isset($data["email"])? print  $data["email"]:'');?>">
                            @if ($errors->has('email'))
                                <br><span class="red">{{ $errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.only_password')：
                            @if(isset($data))
                                <span class="red">@lang('user.only_change')</span>
                            @elseif (!isset($data))
                                <span class="red">@lang('common.required')</span>
                            @endif
                            <input class="form-control" id='pass' type="password" name="pass" size="40"
                            value="{{ old('pass') }}">
                            @if ($errors->has('pass'))
                                <br><span class="red">{{ $errors->first('pass')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @lang('user.password_confirmation')：
                            @if(isset($data))
                                <span class="red">@lang('user.only_change')</span>
                            @elseif (!isset($data))
                                <span class="red">@lang('common.required')</span>
                            @endif
                            <input class="form-control" id='pass_confirmation' type="password" name="pass_confirmation" size="40"
                            value="{{ old('pass_confirmation') }}">
                        </div>
                        <div  class="form-group">
                            @lang('user.user_status')：<span class="red">@lang('common.required')</span>
                            <select name="status" class="form-control">
                            @foreach($userlist_status as $key => $value)
                                <option value={{$key}}
                                <?php
                                if (isset($data["status"]) && $key==$data["status"]){
                                    echo 'selected';
                                } elseif (old('status')== $key){
                                    echo 'selected';
                                }?>>{{$value}}
                                </option>
                            @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <br><span class="red">{{ $errors->first('status')}}</span>
                            @endif
                        </div>
                        <div  class="form-group">
                            @lang('user.role')：<span class="red">@lang('common.required')</span>
                            <select name="role" class="form-control">
                            @foreach($roles as $key => $value)
                                <option value={{$key}}
                                <?php
                                if (isset($data["role"]) && $key==$data["role"]){
                                    echo 'selected';
                                } elseif (old('role')== $key){
                                    echo 'selected';
                                }?>>{{$value}}
                                </option>
                            @endforeach
                            </select>
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
        </div>
    </div>
</div>
@endsection
