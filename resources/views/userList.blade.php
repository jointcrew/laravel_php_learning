
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">@lang('common.user')</div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
                      <p style="color:red;"><?php if(isset($msg)){echo $msg;}?></p>
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
                      @foreach($list as $user)
                          <tr>
                              <td>{{$user->id}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->email}}</td>
                              <td>@lang("user.role_name.$user->role")</td>
                              <td>{{$user->created_at}}</td>
                              <td>
                                  <a href="/userEdit?userId={{$user->id}}" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                  <?php
                                  if($id != $user['id']){
                                  echo  "<a href=\"/userDelete?userId={{$user->id}}\" class=\"btn btn-danger btn-sm\">削除</a>";
                                  }
                                  ?>
                              </td>
                          </tr>
                      @endforeach
                  </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
