@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card" >
                <div class="card-header">@lang('common.menu.goods_settle')</div>
                <div class="col-md-12 justify-content-center">
                    @if ($role==1)
                    <a href="/goodsSearch?stock=1&category=null">@lang('common.back')</a>
                    @endif
                    <form action="/goodsSettle" method="post">
                    @if ($role==5)
                    <div>
                        @if (isset($data["goods_id"]))
                            <input type="hidden" name="goods_id" value={{$data["goods_id"]}}>
                            <input type="hidden" name="purchase_numbers" value={{$data["purchase_number"]}}>
                            <input type="hidden" name="discount_price" value={{$data["discount_price"]}}>
                            <input type="hidden" name="total_price" value={{$data["total_price"]}}>
                            <input type="hidden" name="purchase_price" value={{$data["purchase_price"]}}>
                            <input type="hidden" name="unit_price" value={{$data["unit_price"]}}>
                            <input type="hidden" name="goods_stock" value={{$data["stock"]}}>
                        @endif
                        @if (isset($datalist))
                            <input type="hidden" name="all_once_flag" value='all_once_flag'>
                            @foreach ($datalist['purchase_numbers'] as $key => $value)
                                <input type="hidden" name="purchase_numbers[{{$key}}]" value={{$value}}>
                            @endforeach
                            @foreach ($datalist['discount_price'] as $key => $value)
                                <input type="hidden" name="discount_price[{{$key}}]" value={{$value}}>
                            @endforeach
                            @foreach ($datalist['purchase_price'] as $key => $value)
                                <input type="hidden" name="purchase_price[{{$key}}]" value={{$value}}>
                            @endforeach
                            @foreach ($datalist['total_price'] as $key => $value)
                                <input type="hidden" name="total_price[{{$key}}]" value={{$value}}>
                            @endforeach
                            @foreach ($datalist as $data_unit)
                                @if (isset($data_unit["goods_id"]))
                                    <input type="hidden" name="goods_id[{{$data_unit["goods_id"]}}]" value={{$data_unit["goods_id"]}}>
                                    <input type="hidden" name="unit_price[{{$data_unit["goods_id"]}}]" value={{$data_unit["unit_price"]}}>
                                    <input type="hidden" name="user_id[{{$data_unit["goods_id"]}}]" value={{$id}}>
                                    <input type="hidden" name="multi_goods_stock[{{$data_unit["goods_id"]}}]" value={{$data_unit['stock']}}>
                                @endif
                            @endforeach
                        @endif
                    </div>
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group col-md-12">
                            <a href="/goodsSearch?stock=1&category=null">@lang('common.back')</a>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('goods.goods_name_tittle')<!--商品名--></th>
                                    <th>@lang('goods.unit_price_tittle')<!--単価--></th>
                                    <th>@lang('goods.purchase_number')<!--購入数--></th>
                                    <th>@lang('goods.discount_price')<!--割引額--></th>
                                    <th>@lang('goods.after_discount')<!--割引後金額--></th>
                                </tr>
                            </thead>
                            @if (isset($data))
                            <tr>
                                <td>@if (isset($data["goods_name"]))
                                    <p>{{$data["goods_name"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["unit_price"]))
                                    <p>{{$data["unit_price"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["purchase_number"]))
                                    <p>{{$data["purchase_number"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["discount_price"]))
                                    <p>{{$data["discount_price"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["purchase_price"]))
                                    <p>{{$data["purchase_price"]}}</p>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if (isset($datalist))
                            @foreach ($datalist as $data)
                            <tr>
                                <td>@if (isset($data["goods_name"]))
                                    <p>{{$data["goods_name"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["unit_price"]))
                                    <p>{{$data["unit_price"]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["goods_id"]))
                                    <p>{{$datalist['purchase_numbers'][$data["goods_id"]]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["goods_id"]))
                                    <p>{{$datalist['discount_price'][$data["goods_id"]]}}</p>
                                    @endif
                                </td>
                                <td>@if (isset($data["goods_id"]))
                                    <p>{{$datalist['purchase_price'][$data["goods_id"]]}}</p>
                                    @endif
                                </td>
                                @if (!isset($data["goods_id"]))
                                @break
                                @endif
                            </tr>
                            @endforeach
                            @endif
                        </table>
                        <div class="form-group col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <!--割引-->
                                    @lang('goods.total_discount_price')：
                                </div>
                                <div class="col-md-9">
                                    @if (isset($data["discount_price"]))
                                    <p>{{$data["discount_price"]}}</p>
                                    @endif
                                    @if (isset($total_data["discount_price"]))
                                    <p>{{$total_data["discount_price"]}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <!--請求金額-->
                                    @lang('goods.purchase_price')：
                                </div>
                                <div class="col-md-9">
                                    @if (isset($data["purchase_price"]))
                                    <p>{{$data["purchase_price"]}}</p>
                                    @endif
                                    @if (isset($total_data["purchase_price"]))
                                    <p>{{$total_data["purchase_price"]}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <!--購入-->
                            <input type="submit" class="btn btn-primary" value= @lang('common.purchase')>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
