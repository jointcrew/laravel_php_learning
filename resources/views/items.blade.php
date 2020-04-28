@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('common.add')</div>

                <form action="items" method="post">
                <!-- CSRF保護 -->
               @csrf
                <p>
                  @lang('item.name')：<input type="text" name="item_name" size="40" value="{{ old('item_name') }}">
                      @if ($errors->has('item_name'))
                          <br><span>{{ $errors->first('item_name')}}</span>
                      @endif
                </p>
                <p>
                  @lang('item.apply')：<select name="apply">
                    <option value=1 @if(old('apply')=='1') selected  @endif>@lang('item.apply1')</option>
                    <option value=2 @if(old('apply')=='2') selected  @endif>@lang('item.apply2')</option>
                    <option value=3 @if(old('apply')=='3') selected  @endif>@lang('item.apply3')</option>
                    @if ($errors->has('apply'))
                        <br><span>{{ $errors->first('apply') }}</span>
                    @endif
                  </select>
                </p>
                <p>
                  @lang('item.selector')：
                  <input type="radio" name="selector" value=1 @if(old('selector')=='1') checked  @endif>@lang('item.selector1')
                  <input type="radio" name="selector" value=2 @if(old('selector')=='2') checked  @endif>@lang('item.selector2')
                  @if ($errors->has('selector'))
                      <br><span class="validation">{{ $errors->first('selector') }}</span>
                  @endif
                </p>
                <p>
                    @lang('item.price')：<input type="text" name="price" size="40" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <br><span>{{ $errors->first('price') }}</span>
                    @endif
                  </p>
                <p>
                  <input type="submit" value="保存">
                </p>
                </form>

                <div class="mx-auto">
                    <a href="/itemList">@lang('common.item_list')</a>
                </div>
                <div class="mx-auto">
                    <a href="/itemsearch">@lang('common.item_search')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
