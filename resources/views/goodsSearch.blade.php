
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card" >
                <div class="card-header">@lang('common.search')</div>
                <div class="col-md-12 justify-content-center">
                    <div class="form-group">
                        <!--検索-->
                        <br>
                        @if ($role==1)
                            <input type="submit" class="btn btn-info" value= 'ユーザー管理'>
                        @endif
                    </div>
                    <p>@lang('item.search_item')<!--検索内容--></p>
                    <form action="/goodsSearch" method="get">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--カテゴリ-->
                                @lang('goods.category_tittle')：
                                <select name='category' class="form-control">
                                    @foreach($category as $key => $value)
                                        <option name="category" value={{$key}} @if($request->input('category')==$key) selected @endif>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-5">
                                <!--商品名-->
                                @lang('goods.goods_name_tittle')：
                                <input type="text" class="form-control" name="goods_name" size="40" value="{{ old('goods_name')}}<?php echo $request->input('goods_name');?>">
                                @if ($errors->has('goods_name'))
                                    <br><span class="red">{{ $errors->first('goods_name')}}</span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!--在庫-->
                            <div class="form-group col-md-5">
                                <label class="control-label">@lang('goods.stock_tittle')：</label>
                                @foreach($stock as $key => $value)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="stock" class="custom-control-input" id="custom-radio-{{$key}}" value={{$key}}
                                        @if($request->input("stock")==$key) checked  @endif>
                                        <label class="custom-control-label" for="custom-radio-{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                                @if ($errors->has('stock'))
                                    <br><span class="red">{{ $errors->first('stock')}}</span>
                                @endif
                            </div>
                            <!--特殊-->
                            <div class="form-group col-md-5">
                                <label class="control-label">@lang('goods.goods_info_tittle')：</label>
                                @foreach($item_info as $key => $value)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="item_info_{{$key}}" class="custom-control-input" id="custom-check-{{$key}}"  value={{$key}}
                                        @if($request->input("item_info_$key")==$key) checked @endif>
                                        <label class="custom-control-label" for="custom-check-{{$key}}">{{$value}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <!--検索-->
                            <input type="submit" class="btn btn-primary" value= @lang('common.search')>
                        </div>
                        <div class="form-group">
                            <!--新規登録-->
                            @if ($role==1)
                                <input type="submit" class="btn btn-info" value= @lang('common.new_registrat')>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <form action="/goodsEdit" method="post">
                <input type="hidden" name="all_once_flag" value='all_once_flag'>
                <!-- CSRF保護 -->
                @csrf
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <p>@lang('common.search_list')<!--検索結果--></p>
                                    <th>@lang('goods.category_tittle')<!--カテゴリ--></th>
                                    <th>@lang('goods.goods_name_tittle')<!--商品名--></th>
                                    <th>@lang('goods.stock_goods_info')<!--特殊--></th>
                                    @if ($role==5)
                                        <th>@lang('goods.purchase')<!--購入--></th>
                                    @endif
                                    @if ($role==1)
                                        <th>@lang('user.tittle_status')<!--ステータス--></th>
                                        <th>@lang('goods.total_purchase_number')<!--総購入数--></th>
                                    @endif
                                </tr>
                            </thead>
                            @if (isset($searchlist))
                                @foreach($searchlist as $list)
                                @if ($role==5 && $list->status == 1)
                                @continue
                                @endif
                                <tr>
                                    <td>@lang("goods.category.$list->category")<!--カテゴリ--></td>
                                    <td><a href="/goodsEdit?goods_id={{$list->goods_id}}&total_purchase_number={{$list["purchase_number"]}}">{{$list["goods_name"]}}</a><!--商品名--></td>
                                    <td>@if ($list["stock"] >= 1)<!--在庫-->
                                            <img class="img_stock_on" alt="あり" width="40" height="40" src="/img/stock_on.jpg">
                                        @elseif ($list["stock"] == 0)
                                            <img class="img_stock_on" alt="あり" width="40" height="40" src="/img/sold_out.png">
                                        @endif
                                        @if (isset($list["item_info"]))<!--特殊-->
                                            @if ($list["item_info"]== "1,")
                                                <img class="img_stock_on" alt="あり" width="50" height="40" src="/img/limited_time.png">
                                            @elseif ($list["item_info"]== ",2" )
                                                <img class="img_stock_on" alt="あり" width="50" height="40" src="/img/new_goods.jpg">
                                            @elseif ($list["item_info"]== "1,2")
                                                <img class="img_stock_on" alt="あり" width="50" height="40" src="/img/limited_time.png">
                                                <img class="img_stock_on" alt="あり" width="50" height="40" src="/img/new_goods.jpg">
                                            @endif
                                        @endif
                                    </td>
                                    @if ($role==1)
                                        <td>@lang("user.status.$list->status")<!--ステータス--></td>
                                    @endif
                                    <td>
                                        @if ($role==5)
                                            @if ($list["stock"] >= 1)<!--購入数入力-->
                                                <div>
                                                    <input  type="number" name="purchase_button[{{$list["goods_id"]}}][{{$list["goods_name"]}}][{{$list["unit_price"]}}]" size="10" value="" id={{$list["goods_id"]}}>
                                                    <label for={{$list["goods_id"]}}>@lang('goods.number')</label>
                                                </div>
                                            @endif
                                        @endif
                                        @if ($role==1)<!--直近購入数-->
                                            @if ($list["purchase_number"]==null)
                                                <p>0</p>
                                            @else
                                                {{$list["purchase_number"]}}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </table>
                        <div class="form-group">
                            <!--決済-->
                            <input type="submit" class="btn btn-info" value= @lang('common.settlement')>
                        </div>
                        @if (isset($searchlist))
                            {{ $searchlist->appends(request()->input())->links() }}
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
