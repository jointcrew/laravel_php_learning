@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@lang('unit_test.book_manege')</div>
                    <div class="card-body">
                        <div class="container">
                            @if(session()->has('message'))
                                <div class="alert alert-danger mb-3">
                                    {{session('message')}}
                                </div>
                            @endif
                            @if(isset($msg))
                                <div class="alert alert-info mb-3">
                                    {{$msg}}
                                </div>
                            @endif
                            @if (!isset($insert_list))
                                <!--貸出-->
                                <form class="" action="/book_rent" method="get">
                                    <div class="row border-bottom m-4">
                                        <div class="col-md-1">
                                            @lang('unit_test.rent')
                                        </div>
                                        <div class="col-md-10">
                                            <div class='row col-md-12'>
                                                <!-- book_id -->
                                                <div class='col-md-2'>
                                                    @lang('unit_test.book_id')
                                                </div>
                                                <div class='col-md-3 mb-2'>
                                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="rent_book_id" value="{{ old('id') }}">
                                                </div>
                                                @if ($errors->has('rent_book_id'))
                                                    <br><span class="red">{{ $errors->first('rent_book_id')}}</span>
                                                @endif
                                                <!-- user_id -->
                                                <div class='col-md-2'>
                                                    @lang('unit_test.user_id')
                                                </div>
                                                <div class='col-md-3 mb-2'>
                                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="rent_user_id" value="{{ old('id') }}">
                                                </div>
                                                @if ($errors->has('rent_user_id'))
                                                    <br><span class="red">{{ $errors->first('rent_user_id')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" class="btn btn-primary" value= @lang('unit_test.rent')>
                                        </div>
                                    </div>
                                </form>
                                <!--返却-->
                                <form class="" action="book_return" method="get">
                                    <div class="row border-bottom m-4">
                                        <div class="col-md-1">
                                            @lang('unit_test.return')
                                        </div>
                                        <div class="col-md-10">
                                            <div class='row col-md-12'>
                                                <!-- book_id -->
                                                <div class='col-md-2'>
                                                    @lang('unit_test.book_id')
                                                </div>
                                                <div class='col-md-3 mb-2'>
                                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="return_book_id" value="{{ old('return_id') }}">
                                                </div>
                                                @if ($errors->has('return_book_id'))
                                                    <br><span class="red">{{ $errors->first('return_book_id')}}</span>
                                                @endif
                                                <!-- user_id -->
                                                <div class='col-md-2'>
                                                    @lang('unit_test.user_id')
                                                </div>
                                                <div class='col-md-3 mb-2'>
                                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="return_user_id" value="{{ old('return_id') }}">
                                                </div>
                                                @if ($errors->has('return_user_id'))
                                                    <br><span class="red">{{ $errors->first('return_user_id')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="submit" class="btn btn-danger" value= @lang('unit_test.return')>
                                        </div>
                                    </div>
                                </form>
                                <!--登録-->
                                <form class="" action="/book_register" method="post">
                                    <!-- CSRF保護 -->
                                    @csrf
                                    <div class="row  m-4">
                                        <div class="col-md-1">
                                            @lang('unit_test.register')
                                        </div>
                                        <div class="col-md-10">
                                            <div class='row col-md-12 mb-2'>
                                                <!-- タイトル -->
                                                <div class='col-md-2'>
                                                    @lang('unit_test.title')
                                                </div>
                                                <div class='col-md-10'>
                                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                                </div>
                                                @if ($errors->has('title'))
                                                    <br><span class="red">{{ $errors->first('title')}}</span>
                                                @endif
                                            </div>
                                            <div class='row col-md-12 mb-2'>
                                                <div class='col-md-2'>
                                                    <!-- 著者 -->
                                                    @lang('unit_test.author')
                                                </div>
                                                <div class='col-md-10'>
                                                    <input type="text" class="form-control" name="author" value="{{ old('author') }}">
                                                </div>
                                                @if ($errors->has('author'))
                                                    <br><span class="red">{{ $errors->first('author')}}</span>
                                                @endif
                                            </div>
                                            <div class='row col-md-12 mb-2'>
                                                <div class='col-md-2'>
                                                    <!-- 説明 -->
                                                    @lang('unit_test.description')
                                                </div>
                                                <div class='col-md-10'>
                                                    <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                                                </div>
                                                @if ($errors->has('description'))
                                                    <br><span class="red">{{ $errors->first('description')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-1 mt-5">
                                            <input type="submit" class="btn btn-success" value= @lang('unit_test.register')>
                                        </div>
                                </form>
                            @endif
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>@lang('unit_test.id')</th>
                                        <th>@lang('unit_test.author')</th>
                                        <th>@lang('unit_test.title')</th>
                                        <th>@lang('unit_test.description')</th>
                                        <th>@lang('unit_test.rent_user')</th>
                                        <th>@lang('unit_test.rent_status')</th>
                                    </tr>
                                </thead>
                                @if (isset($datalist))
                                    @foreach($datalist as $data)
                                        <tr>
                                            <td>{{$data["id"]}}</td>
                                            <td>{{$data["author"]}}</td>
                                            <td>{{$data["title"]}}</td>
                                            <td>{{$data["description"]}}</td>
                                            <td></td>
                                            <td>@lang("unit_test.status.{$data['status']}")</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if (isset($insert_list))
                                    <tr>
                                        <td>{{$insert_list["id"]}}</td>
                                        <td>{{$insert_list["author"]}}</td>
                                        <td>{{$insert_list["title"]}}</td>
                                        <td>{{$insert_list["description"]}}</td>
                                        <td></td>
                                        <td>@lang("unit_test.status.{$insert_list['status']}")</td>
                                    </tr>
                                    <a class="btn btn-outline-primary mb-3" href="/book_manage">@lang('common.back')</a>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
