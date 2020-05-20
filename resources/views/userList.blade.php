@extends('layouts.app')
<script src="{{ asset('js/api_itemuser.js') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">@lang('common.user')</div>
                <div class="card-body">
                  <form action="/userApiSearch" method="get">
                    <!-- CSRF保護 -->
                   @csrf
                  <!-- 一覧 -->
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
                              <td>{{$user["id"]}}</td>
                              <td>{{$user["name"]}}</td>
                              <td>{{$user["email"]}}</td>
                              <td>@lang("user.role_name.{$user['role']}")</td>
                              <td>{{$user["created_at"]}}</td>
                              <td>
                                  <a href="/userEdit?userId={{$user["id"]}}" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                  <?php
                                  if($create_user_id != $user['id']){
                                  echo  "<a href=\"/userDelete?userId={{$user["id"]}}\" class=\"btn btn-danger btn-sm\">削除</a>";
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
