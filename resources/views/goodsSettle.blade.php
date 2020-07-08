@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card" >
                <div class="card-header">@lang('common.menu.goods_settle')</div>
                <div class="col-md-12 justify-content-center">
                @if ($role==1)
                    <a href="/goodsSearch">@lang('common.back')</a>
                @endif
                @if ($role==5)
                    <form action="/goodsSettle" method="post">
                        @if (isset($data["goods_id"]))
                            <input type="hidden" name="data" value={{$data}}>
                            <input type="hidden" name="goods_id" value={{$data["goods_id"]}}>
                            <input type="hidden" name="purchase_number" value={{$data["purchase_number"]}}>
                            <input type="hidden" name="discount_price" value={{$data["discount_price"]}}>
                            <input type="hidden" name="total_price" value={{$data["total_price"]}}>
                            <input type="hidden" name="purchase_price" value={{$data["purchase_price"]}}>
                            <input type="hidden" name="unit_price" value={{$data["unit_price"]}}>
                        @endif
                          <!-- CSRF保護 -->
                         @csrf
                         <div class="form-group col-md-12">
                             <a href="/goodsSearch">@lang('common.back')</a>
                         </div>
                         <div class="form-group col-md-10">
                             <div class="row">
                                 <div class="col-md-2">
                                     <!--商品名-->
                                     @lang('goods.goods_name_tittle')：
                                 </div>
                                 <div class="col-md-10">
                                     @if (isset($data["goods_name"]))
                                         <p>{{$data["goods_name"]}}</p>
                                     @endif
                                     @if (isset($datalist))
                                         @foreach ($datalist as $_data)
                                            {{$_data["goods_name"]}},
                                         @endforeach
                                     @endif
                                 </div>
                            </div>
                         </div>
                         <div class="form-group col-md-10">
                             <div class="row">
                                 <div class="col-md-2">
                                     <!--単価-->
                                     @lang('goods.unit_price_tittle')：
                                </div>
                                <div class="col-md-10">
                                     @if (isset($data["unit_price"]))
                                         <p>{{$data["unit_price"]}}</p>
                                     @endif
                                     @if (isset($datalist))
                                         @foreach ($datalist as $_data)
                                            <span>{{$_data["unit_price"]}},</span>
                                         @endforeach
                                     @endif
                                 </div>
                             </div>
                         </div>
                         <div class="form-group col-md-10">
                             <div class="row">
                                 <div class="col-md-2">
                                     <!--購入数-->
                                     @lang('goods.purchase_number')：
                                 </div>
                                 <div class="col-md-10">
                                     @if (isset($data["purchase_number"]))
                                         <p>{{$data["purchase_number"]}}</p>
                                     @endif
                                     @if (isset($purchase_number))
                                         @foreach ($purchase_number as $number)
                                            <span>{{$number}},</span>
                                         @endforeach
                                     @endif
                                 </div>
                             </div>
                         </div>
                         <div class="form-group col-md-10">
                             <div class="row">
                                 <div class="col-md-2">
                                     <!--割引-->
                                     @lang('goods.discount_price')：
                                 </div>
                                 <div class="col-md-10">
                                     @if (isset($data["discount_price"]))
                                         <p>{{$data["discount_price"]}}</p>
                                     @endif
                                 </div>
                             </div>
                         </div>
                         <div class="form-group col-md-10">
                             <div class="row">
                                 <div class="col-md-2">
                                     <!--請求金額-->
                                     @lang('goods.purchase_price')：
                                 </div>
                                 <div class="col-md-10">
                                     @if (isset($data["purchase_price"]))
                                         <p>{{$data["purchase_price"]}}</p>
                                     @endif
                                 </div>
                             </div>
                         </div>
                        <div class="form-group">
                            <!--決済-->
                            <input type="submit" class="btn btn-primary" value= @lang('common.purchase')>
                        </div>
                    </form>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
