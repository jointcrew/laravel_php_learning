@extends('layouts.app')
<script src="{{ asset('js/api_itemuser.js') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">@lang('common.user')</div>
                <div class="form-group col-md-5">
                    <a href="/goodsSearch">@lang('common.back')</a>
                </div>
                <div class="card-body">
                        <table class="table table-striped table-hover">
                            <p style="color:red;"><?php if(isset($msg)){echo $msg;}?></p>
                            <thead>
                                <tr>
                                    <th>@lang('user.user_name')</th>
                                    <th>@lang('user.role')</th>
                                    <th>@lang('user.email')</th>
                                    <th>@lang('user.user_status')</th>
                                    <th>@lang('user.summary')</th>
                                </tr>
                            </thead>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="form-inline">
                            <div class="form-group">
                                <!--戻る-->
                                <input type="submit" class="btn btn-primary" value= @lang('common.back')>
                            </div>
                            <div class="form-group">
                                <!--サマリ-->
                                <input type="submit" class="btn btn-outline-primary" value= @lang('user.summary')>
                            </div>
                            <div class="form-group">
                                <!--新規登録-->
                                <a href="/goodsUserEdit" class="btn btn-outline-info">@lang('common.new_registrat')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
