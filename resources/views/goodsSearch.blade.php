
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!--購入メッセージ-->
            @if (!is_null($msg))
                <div class="card">
                    <div class="card-header">@lang('common.resalt')</div>
                    <div class="col-md-12 justify-content-center">
                        <span class="red">{{$msg}}</span>
                    </div>
                </div>
            @endif
            <br>
            <div class="card" >
                <div class="card-header">@lang('common.search')</div>
                <div class="col-md-12 justify-content-center">
                    <div class="form-group">
                        <!--ユーザー管理-->
                        <br>
                        @if ($role==1)
                            <a href="/goodsUser" class="btn btn-info">@lang('common.user_manage')</a>
                        @endif
                    </div>
                    <div>
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
                                        <option name="category" value={{$key}}
                                        @if ($request->input('category')==$key)
                                            selected
                                        @endif>
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
                                @if (($request->input("stock"))==null)
                                    @foreach($stock as $key => $value)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="stock" class="custom-control-input" id="custom-radio-{{$key}}" value={{$key}}
                                            @if (1==$key)
                                                checked
                                            @endif
                                            >
                                            <label class="custom-control-label" for="custom-radio-{{$key}}">{{$value}}</label>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($stock as $key => $value)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="stock" class="custom-control-input" id="custom-radio-{{$key}}" value={{$key}}
                                            @if ($request->input("stock")==$key)
                                                checked
                                            @endif
                                            >
                                            <label class="custom-control-label" for="custom-radio-{{$key}}">{{$value}}</label>
                                        </div>
                                    @endforeach
                                @endif
                                @if ($errors->has('stock'))
                                    <br><span class="red">{{ $errors->first('stock')}}</span>
                                @endif
                                <?php //var_dump($request->input("stock"));?>
                            </div>
                            <!--特殊-->
                            <div class="form-group col-md-5">
                                <label class="control-label">@lang('goods.goods_info_tittle')：</label>
                                @foreach($item_info as $key => $value)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="item_info_{{$key}}" class="custom-control-input" id="custom-check-{{$key}}"  value={{$key}}
                                        @if ($request->input("item_info_$key")==$key)
                                            checked
                                        @endif>
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
                                <a href="/goodsEdit" class="btn btn-info">@lang('common.new_registrat')</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <form action="/beforeSettle" method="post">
                <input type="hidden" name="all_once_flag" value='all_once_flag'>
                <!-- CSRF保護 -->
                @csrf
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <p>@lang('common.search_list')<!--検索結果--></p>
                                    @if ($role == 5)
                                        @lang('goods.input_purchase')
                                    @endif
                                    <th>@lang('goods.category_tittle')<!--カテゴリ--></th>
                                    <th>@lang('goods.goods_name_tittle')<!--商品名--></th>
                                    <th>@lang('goods.stock_tittle')<!--在庫数--></th>
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
                                    <input type="hidden" name="goods_stock[{{$list["goods_id"]}}]" value={{$list["stock"]}}>
                                    @if ($role==5 && $list->status == 1)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>@lang("goods.category.$list->category")<!--カテゴリ--></td>
                                        <td><a href="/goodsDetail?goods_id={{$list->goods_id}}&total_purchase_number={{$list["purchase_number"]}}">{{$list["goods_name"]}}</a><!--商品名--></td>
                                        <td>{{$list["stock"]}}<!--在庫数--></td>
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
                                                @if ($list["stock"] >= 1)<!--在庫ありだったら、購入数入力  -->
                                                    <div>
                                                        <input oninput="this.value = Math.abs(this.value)" min="0"  type="number"
                                                        name="purchase_number[{{$list["goods_id"]}}]" size="10" id={{$list["goods_id"]}}
                                                        value="<?php $goods_id = $list["goods_id"];print old("purchase_number.$goods_id");?>">
                                                        <label for={{$list["goods_id"]}}>@lang('goods.number')</label>
                                                        <p>
                                                            <span class='red'>
                                                                <?php
                                                                $goods_id = $list["goods_id"];
                                                                print $errors->first("purchase_number.$goods_id");
                                                                ?>
                                                            </span>
                                                        </p>
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
                        @if ($role==5)
                            <div class="form-group">
                                <!--決済-->
                                <input type="submit" class="btn btn-info" value= @lang('common.settlement')>
                            </div>
                        @endif
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
