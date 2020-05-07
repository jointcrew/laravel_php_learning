
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">@lang('common.user')</div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
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
                              <td>{{$user->role}}</td>
                              <td>{{$user->created_at}}</td>
                              <td>
                                  <a href="/userEdit?userId={{$user->id}}" class="btn btn-primary btn-sm">@lang('sample.edit_link')</a>
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
