@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('item.title')</div>

                <form action="items" method="post">
                <!-- CSRF保護 -->
               @csrf
                <p>
                  @lang('item.name')：<input type="text" name="item_name" size="40">
                </p>
                <p>
                  @lang('item.apply')：<select name="apply">
                    <option value=1>@lang('item.apply1')</option>
                    <option value=2>@lang('item.apply2')</option>
                    <option value=3>@lang('item.apply3')</option>
                  </select>
                </p>
                <p>
                  @lang('item.selector')：
                  <input type="radio" name="selector" value=1>@lang('item.selector1')
                  <input type="radio" name="selector" value=2>@lang('item.selector2')
                </p>
                <p>
                    @lang('item.price')：<input type="text" name="price" size="40">
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
