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
               <div class="form-group">
                <p>
                  @lang('user.name')：
                  <input class="form-control" type="text" name="name" size="40" value="{{$data->name}}" >
                </p>
                </div>
                <div class="form-group">
                <p>
                    @lang('user.email')：
                    <input class="form-control" type="text" name="email" size="40" value="{{$data->email}}" >
                </p>
                </div>
                <div class="form-group">
                <p>
                  @lang('user.role')：
                  <input class="form-control" type="text" name="role" size="40" value="{{$data->role}}" >
                </p>
                </div>
                <div class="form-group">
                <p>
                    @lang('user.created_at')：{{$data->created_at}}"
                </p>
                </div>
                <div class="form-group">
                  <p>
                    <input type="submit"  class="btn btn-primary" value=@lang('common.save')>
                  </p>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
