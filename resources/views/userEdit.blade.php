@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('user.edit')</div>
                <form class="col-md-12" action="/userEdit" method="post">
                <!-- CSRF保護 -->
               @csrf
               <input type="hidden" name="user_id" value="{{$user_id}}">
                 <p >
                   @lang('user.id')：{{$data->id}}
                 </p>
                 <div>
                 <p>
                     @lang('user.created_at')：{{$data->created_at}}"
                 </p>
                 </div>
               <div class="form-group">
                  @lang('user.name')：
                  <input class="form-control" type="text" name="name" size="40" value="{{$data->name}}" >
                </div>
                <div class="form-group">
                    @lang('user.email')：
                    <input class="form-control" type="text" name="email" size="40" value="{{$data->email}}" >
                </div>
                <div class="form-group">
                    @lang('user.password')：
                    <input class="form-control" id='password' type="password" name="password" size="40" >
                    @if ($errors->has('password'))
                        <br><span style="color:red;">{{ $errors->first('password')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    @lang('user.password_confirmation')：
                    <input class="form-control" id='password_confirmation' type="password" name="password_confirmation" size="40" >
                    @if ($errors->has('password_confirmation'))
                        <br><span style="color:red;">{{ $errors->first('password_confirmation')}}</span>
                    @endif
                </div>
                <div  class="form-group">
                  @lang('user.role')：<select name="role" class="form-control">
                    <option value=1
                        <?php if( !empty($data['role']) && $data['role']=="1"){ echo 'selected'; } ?>>@lang('user.admin')</option>
                    <option value=5
                        <?php if( !empty($data['role']) && $data['role']=="5"){ echo 'selected'; } ?>>@lang('user.user')</option>
                </div>
                <div class="form-group">
                    <input type="submit"  class="btn btn-primary" value=@lang('common.save')>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
