@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">@lang('common.add')</div>
                  <div class="col-md-12">
                <form action="items" method="post">
                <!-- CSRF保護 -->
               @csrf
               <div class="form-group">
                 <!--商品名-->
                 @lang('item.name')：
                  <input type="text" class="form-control" id="item_name" name="item_name" size="40" value="{{ old('item_name') }}">
                      @if ($errors->has('item_name'))
                          <br><span style="color:red;">{{ $errors->first('item_name')}}</span>
                      @endif
               </div>
               <div class="form-group">
                 <!--かな名-->
                  @lang('item.name_kana')：
                  <input type="text" class="form-control" id="item_name_kana" name="item_name_kana" size="40" value="{{ old('item_name_kana') }}">
                      @if ($errors->has('item_name_kana'))
                          <br><span style="color:red;">{{ $errors->first('item_name_kana')}}</span>
                      @endif
                 </p>
               </div>
               <div class="form-group">
                <!--申請先-->
                @lang('item.apply')：
                  <select name="apply" class="form-control">
                    <option value=1 @if(old('apply')=='1') selected  @endif>@lang('item.apply1')</option>
                    <option value=2 @if(old('apply')=='2') selected  @endif>@lang('item.apply2')</option>
                    <option value=3 @if(old('apply')=='3') selected  @endif>@lang('item.apply3')</option>
                    @if ($errors->has('apply'))
                        <br><span style="color:red;">{{ $errors->first('apply') }}</span>
                    @endif
                  </select>
              </div>
              <div class="form-group">
                <!--種別-->
                @lang('item.selector')：
                  <input type="radio" name="selector" value=1 @if(old('selector')=='1') checked  @endif>@lang('item.selector1')
                  <input type="radio" name="selector" value=2 @if(old('selector')=='2') checked  @endif>@lang('item.selector2')
                  @if ($errors->has('selector'))
                      <br><span style="color:red;" class="validation">{{ $errors->first('selector') }}</span>
                  @endif
              </div>
              <div class="form-group">
                <!--値段-->
                    @lang('item.price')：
                    <input type="text" class="form-control" id="price" name="price" size="40" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <br><span style="color:red;">{{ $errors->first('price') }}</span>
                    @endif
                </p>
              </div>
              <div class="form-group">
                <p><!--保存ボタン-->
                  <input type="submit" class="btn btn-primary" value=@lang('common.add_btm')>
                </p>
              </div>
                </form>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
