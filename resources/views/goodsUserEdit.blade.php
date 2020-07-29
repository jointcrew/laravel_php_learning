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
                    <form action="/userApiRegister" method="get">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group">
                            @lang('user.user_name')：
                            <input class="form-control" type="text" name="name" size="40"  >
                        </div>
                        <div class="form-group">
                            @lang('user.email')：
                            <input class="form-control" type="text" name="email" size="40"  >
                        </div>
                        <div class="form-group">
                            @lang('user.user_status')：
                            <input class="form-control" id='password' type="password" name="password" size="40" >
                        </div>
                        <div  class="form-group">
                            @lang('user.role')：<select name="role" class="form-control">
                                @foreach($roles as $key => $value)
                                <option value={{$key}}>{{$value}}</option>
                                @endforeach
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
