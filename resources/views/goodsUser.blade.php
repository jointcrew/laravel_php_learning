@extends('layouts.app')
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script src="{{ asset('js/goods_ajax.js?20200902') }}" defer></script>
<script src="{{ asset('js/user_summary_pegenatin.js?1') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                @if (!isset($msg))
                    <div class="card-header">@lang('common.user')</div>
                @elseif (isset($msg))
                    <br>
                    <div class="form-group col-md-5">
                        <a href="/goodsUser">@lang('common.user_list')</a>
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <p style="color:red;"><?php if(isset($msg)){echo $msg;}?></p>
                        <thead>
                            <tr>
                                <th>@lang('user.id')</th>
                                <th>@lang('user.user_name')</th>
                                <th>@lang('user.role')</th>
                                <th>@lang('user.email')</th>
                                <th>@lang('user.user_status')</th>
                                <th>@lang('user.summary')</th>
                            </tr>
                        </thead>
                        @if (!isset($insert_data))
                            @if (isset($userlist))
                                @foreach ($userlist as $list)
                                <tr>
                                    <td>{{$list["id"]}}</td>
                                    <td><a href="/goodsUserEdit?user_id={{$list->id}}">{{$list["name"]}}</a></td>
                                    <td>@lang("user.role_name.$list->role")</td>
                                    <td>{{$list["email"]}}</td>
                                    <td>@lang("user.userlist_status.$list->status")</td>
                                    <td><div>
                                        <input oninput="this.value = Math.abs(this.value)" min="0"  type="checkbox" name="summary"  value={{$list["id"]}} id={{$list["id"]}}>
                                        <label for={{$list["id"]}}></label>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        @elseif (isset($insert_data))
                            <tr>
                                <td>{{$insert_data["id"]}}</td>
                                <td><a href="/goodsUserEdit?user_id={{$insert_data["id"]}}">{{$insert_data["name"]}}</a></td>
                                <td>@lang("user.role_name.{$insert_data['role']}")</td>
                                <td>{{$insert_data["email"]}}</td>
                                <td>@lang("user.userlist_status.{$insert_data['status']}")</td>
                                <td><div>
                                    <input type="checkbox" name="summary"  value={{$insert_data["id"]}} id={{$insert_data["id"]}}>
                                    <label for={{$insert_data["id"]}}></label>
                                </div>
                                </td>
                            </tr>
                        @endif
                    </table>
                    @if (isset($userlist))
                        {{ $userlist->appends(request()->input())->links() }}
                    @endif
                    <div class="form-inline">
                        <div class="form-group">
                            <!--戻る-->
                            <a href="/goodsSearch" class="btn btn-primary">@lang('common.back')</a>
                        </div>
                        <div class="form-group">
                            <!--サマリ-->
                            <input type="submit" class="btn btn-outline-primary" data-toggle="modal" data-target="#Modal" value= @lang('user.summary') data-checkbox="haruka">
                        </div>
                        <div class="form-group">
                            <!--新規登録-->
                            <a href="/goodsUserEdit" class="btn btn-outline-info">@lang('common.new_registrat')</a>
                        </div>
                    </div>
                    <!-- モーダルの設定 -->
                    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
                        <!--以下modal-dialogのCSSの部分で modal-lgやmodal-smを追加するとモーダルのサイズを変更することができる-->
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action='/api/api_goodsuser'  id="the_form">
                                    <div class="modal-header">
                                      <p class="modal-title font-weight-bold" id="">@lang('user.user_summary')</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="@lang('user.close')">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <!--カテゴリ-->
                                            <div class="col-2">
                                                @lang('goods.category_tittle')：
                                            </div>
                                            <div class="col-4">
                                                <select name='category' class="form-control" id='category'>
                                                    @foreach($category as $key => $value)
                                                    <option name="category" value={{$key}}>
                                                        {{$value}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--商品名-->
                                            <div class="col-2">
                                                @lang('goods.goods_name_tittle')：
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" name="goods_name" size="40" value="{{ old('goods_name')}}" id='goods_name'>
                                                @if ($errors->has('goods_name'))
                                                <br><span class="red">{{ $errors->first('goods_name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <!--購入金額指定-->
                                            <div class="col-2">
                                                @lang('goods.buy_price')：
                                            </div>
                                            <div class="col-4">
                                                <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control"  name="price_start" value="{{ old('price_start') }}" id='price_start'>
                                            </div>
                                            <div class="col-2">
                                                <a>　　～</a>
                                            </div>
                                            <div class="col-4">
                                                <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control"  name="price_end" value="{{ old('price_end') }}" id='price_end'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <!--日付指定-->
                                            <div class="col-2">
                                                @lang('item.create_at')：
                                            </div>
                                            <div class="col-4">
                                                <input type="date" class="form-control" name="date_start" value="{{ old('date_start') }}" id='date_start'>
                                            </div>
                                            <div class="col-2">
                                                <a>　　～</a>
                                            </div>
                                            <div class="col-4">
                                                <input type="date" class="form-control" name="date_end" value="{{ old('date_end') }}" id='date_end'>
                                            </div>
                                        </div>
                                        <div class="pull-right form-group">
                                            <!--検索-->
                                            <input type="submit" class="btn btn-primary" value= @lang('common.search')  id="form_buttum">
                                        </div>
                                        <!--チェックしたユーザーid-->
                                        <input type="hidden" name="user_id" id="user_id" value=>
                                        <div>
                                            <table id='table' class="table table-striped table-hover">
                                                <tr>
                                                  <th>@lang('user.user_name')</th>
                                                  <th>@lang('goods.goods_name_tittle')</th>
                                                  <th>@lang('goods.purchase_number')</th>
                                                  <th>@lang('goods.price')</th>
                                                  <th>@lang('goods.discount_price')</th>
                                                    <th>@lang('goods.purchase_date')</th>
                                                </tr>
                                              </table>
                                            <!-- pagenate -->
                                            <ul class="pagination" id="pagination">
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
