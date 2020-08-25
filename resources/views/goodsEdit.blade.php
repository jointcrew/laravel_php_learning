@extends('layouts.app')

<script src="{{ asset('js/form_action_change.js?202008190') }}" defer></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card" >
                <div id="t1"></div>
                @if ($role==1)
                    <div class="card-header">@lang('common.menu.goods_edit')</div>
                @elseif ($role==5)
                    <div class="card-header">@lang('common.menu.goods_detail')</div>
                @endif
                <div class="col-md-12 justify-content-center">
                    <form id='form' name='form' method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        @if (isset($data["goods_id"]))
                            <input type="hidden" name="goods_id" value={{$data["goods_id"]}}>
                            <input type="hidden" name="total_purchase_number" value={{$data["total_purchase_number"]}}>
                        @endif
                        @if (isset($msg))
                            <span class="red">{{$msg}}</span>
                        @endif
                        <div class="form-group col-md-5">
                            <a href="/goodsSearch?stock=1&category=null">@lang('common.back')</a>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--カテゴリ-->
                                @lang('goods.category_tittle')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <select name='category' class="form-control">
                                        @foreach($category as $key => $value)
                                        <option name="category" value={{$key}}
                                        <?php
                                        if (old('category')){
                                            if (old('category')==$key) {
                                                echo 'selected';
                                            }
                                        }  elseif (isset($data["category"]) && $key==$data["category"]){
                                            echo 'selected';
                                        }?>
                                        >{{$value}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <br><span class="red">@lang('validation.category')</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @foreach($category as $key => $value)
                                        @if (isset($data["category"]) && $key==$data["category"])
                                            <p>{{$value}}</p>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group col-md-5">
                                <!--種別-->
                                @lang('goods.type_tittle')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <select name='type' class="form-control">
                                    @foreach($type as $key => $value)
                                        <option name="type" value={{$key}}
                                        <?php
                                        if (old('type')){
                                            if (old('type')==$key) {
                                                echo 'selected';
                                            }
                                        }  elseif (isset($data["type"]) && $key==$data["type"]){
                                            echo 'selected';
                                        }?>
                                        >{{$value}}
                                        </option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('type'))
                                        <br><span class="red">@lang('validation.type')</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @foreach($type as $key => $value)
                                        @if (isset($data["type"]) && $key==$data["type"])
                                            <p>{{$value}}</p>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--商品名-->
                                @lang('goods.goods_name_tittle')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <input type="text" class="form-control" name="goods_name" size="40"
                                    value="<?php old('goods_name')? print old('goods_name'):(isset($data["goods_name"])? print  $data["goods_name"]:'');?>">
                                    @if ($errors->has('goods_name'))
                                        <br><span class="red">{{ $errors->first('goods_name')}}</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @if (isset($data["goods_name"]))
                                        <p>{{$data["goods_name"]}}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--在庫-->
                                @lang('goods.stock_tittle')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="stock" size="40"
                                    value="<?php old('stock')? print old('stock'):(isset($data["stock"])? print  $data["stock"]:'');?>">
                                    @if ($errors->has('stock'))
                                        <br><span class="red">{{ $errors->first('stock')}}</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @if (isset($data["stock"]))
                                        @if ($data["stock"]>=1 && $data["stock"]<=5)
                                            <p>@lang('goods.little_stock')</p>
                                            <p>残り{{$data["stock"]}}個</p>
                                        @elseif ($data["stock"]>5)
                                            <p>@lang('goods.in_stock')</p>
                                            <p>残り{{$data["stock"]}}個</p>
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="form-group col-md-5">
                                <!--特殊-->
                                <div class="form-group col-md-5">
                                    <label class="control-label">@lang('goods.goods_info_tittle')：</label>
                                    @if ($role==1)
                                        @foreach($item_info as $key => $value)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="item_info[{{$key}}]" class="custom-control-input" id="custom-check-{{$key}}"
                                                value={{$key}}
                                                @if (!empty(old("item_info")))
                                                    @if (!empty(old("item_info.$key")))
                                                        checked
                                                    @endif
                                                @elseif (empty(old("item_info")) && $errors->any())
                                                @elseif (!empty($data["item_info"]))
                                                    @foreach ($data["item_info"] as $item_info)
                                                        @if ($key==$item_info)
                                                            checked
                                                        @endif
                                                    @endforeach
                                                @endif
                                                >
                                                <label class="custom-control-label" for="custom-check-{{$key}}">{{$value}}</label>
                                            </div>
                                        @endforeach
                                        @if ($errors->has('item_info'))
                                            <br><span class="red">{{ $errors->first('item_info')}}</span>
                                        @endif
                                    @endif
                                    @if ($role==5)
                                        @foreach($item_info as $key => $value)
                                            @foreach($data->item_info as $item_info)
                                                @if ($key==$item_info)
                                                    <p>{{$value}}</p>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        @if (!($data->item_info))
                                            <p>@lang('common.none')</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--単価-->
                                @lang('goods.unit_price_tittle')@lang('common.(yen)')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="unit_price" size="40"
                                    value="<?php old('unit_price')? print old('unit_price'):(isset($data["unit_price"])? print  $data["unit_price"]:'');?>">
                                    @if ($errors->has('unit_price'))
                                        <br><span class="red">{{ $errors->first('unit_price')}}</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @if (isset($data["unit_price"]))
                                        <p>{{$data["unit_price"]}}@lang('common.yen')</p>
                                    @endif
                                @endif
                            </div>
                            <div class="form-group col-md-5">
                                <!--割引-->
                                @lang('goods.discount_number_tittle')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                                @if ($role==1)
                                    <select name='discount_number' class="form-control">
                                    @foreach($discount_number as $key => $value)
                                        <option name="discount_number" value={{$key}}
                                        <?php
                                        if (old('discount_number')){
                                            if (old('discount_number')==$key) {
                                                echo 'selected';
                                            }
                                        }  elseif (isset($data["discount_number"]) && $key==$data["discount_number"]){
                                            echo 'selected';
                                        }
                                        ?>>{{$value}}
                                        </option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('discount_number'))
                                        <br><span class="red">@lang('validation.discount_number')</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @foreach($discount_number as $key => $value)
                                        @if (isset($data["discount_number"]) && $key==$data["discount_number"])
                                            @if ($data["discount_number"]==0)
                                                <p>@lang('goods.discount_none')</p>
                                            @elseif ($data["discount_number"]>=1)
                                                <p>購入数が{{$data["discount_number"]}}個以上で割引</p>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <!--コメント、ifの所を改行すると表示の際変な隙間が出来てしまう-->
                                @lang('goods.comment_tittle')：
                                @if ($role==1)
                                    <textarea class="form-control" name="comment" size="40" rows="4" cols="250"><?php old('comment')? print old('comment'):(isset($data["comment"])? print  $data["comment"]:'');?></textarea>
                                    @if ($errors->has('comment'))
                                        <br><span class="red">{{ $errors->first('comment')}}</span>
                                    @endif
                                @endif
                                @if ($role==5)
                                    @if (isset($data["comment"]))
                                        <p>{{$data["comment"]}}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-5 row">
                            @if ($role==5)
                                <!--購入数-->
                                @lang('goods.purchase_number_tittle')：
                                <input oninput="this.value = Math.abs(this.value)" min="0" type="number" class="form-control" name="purchase_number" size="40">
                                @if ($errors->has('purchase_number'))
                                    <br><span class="red">{{ $errors->first('purchase_number') }}</span>
                                @endif
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                @if ($role==1)
                                    <!--総購入数-->
                                    @lang('goods.total_purchase_number')：
                                    @if ($data["total_purchase_number"]==null)
                                        <p>0 @lang('goods.count')</p>
                                    @else
                                        <p>{{$data["total_purchase_number"]}}@lang('goods.count')</p>
                                    @endif
                                @endif
                                @if ($role==5)
                                    <!--売れ筋-->
                                    @lang('goods.sales')
                                    @if ($data["total_purchase_number"]==null)
                                        0
                                    @else
                                        {{$data["total_purchase_number"]}}
                                    @endif
                                    @lang('goods.count')
                                @endif
                            </div>
                        </div>
                        @if ($role==1)
                        <div class="form-group col-md-5 row">
                            <!--ステータス-->
                            @lang('user.user_status')：@if($role==1)<span class="red">@lang('common.required')</span>@endif
                            <select name='status' class="form-control">
                                @foreach($status as $key => $value)
                                    <option name="status" value={{$key}}
                                    <?php
                                    if (isset($data["status"]) && $key==$data["status"]){
                                        echo 'selected';
                                    } elseif (old('status')== $key){
                                        echo 'selected';
                                    }?>>{{$value}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <br><span class="red">{{ $errors->first('status')}}</span>
                            @endif
                        </div>
                        @endif
                        <div class="form-group">
                            @if ($role==1)
                                <!--保存-->
                                <input type="submit" onclick="action_role1();" class="btn btn-primary" value= @lang('common.save')>
                            @endif
                            @if ($role==5)
                                <!--決済-->
                                <input type="submit" onclick="action_role5();" class="btn btn-primary" value= @lang('common.settlement')>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
