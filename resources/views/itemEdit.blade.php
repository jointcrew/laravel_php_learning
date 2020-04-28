@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('item.Edit')</div>

                <form action="/itemEdit" method="post">
                <!-- CSRF保護 -->
               @csrf
               <input type="hidden" name="item_id" value="{{$item_id}}">
                <p>
                  @lang('item.name')：<input type="text" name="item_name" size="40" value="{{$data->item_name}}" >
                </p>
                <p>
                  @lang('item.apply')：<select name="apply">
                    <option value=1
                        <?php if( !empty($data['apply']) && $data['apply']=="1"){ echo 'selected'; } ?>>@lang('item.apply1')</option>
                    <option value=2
                        <?php if( !empty($data['apply']) && $data['apply']=="2"){ echo 'selected'; } ?>>@lang('item.apply2')</option>
                    <option value=3
                        <?php if( !empty($data['apply']) && $data['apply']=="3"){ echo 'selected'; } ?>>@lang('item.apply3')</option>
                  </select>
                </p>
                <p>
                  @lang('item.selector')：
                  <input type="radio" name="selector" value=1
                      <?php if( !empty($data['selector']) && $data['selector']=="1"){ echo 'checked'; } ?>>@lang('item.selector1')
                  <input type="radio" name="selector" value=2
                      <?php if( !empty($data['selector']) && $data['selector']=="2"){ echo 'checked'; } ?>>@lang('item.selector2')
                </p>
                <p>
                    @lang('item.price')：<input type="text" name="price" size="40" value="{{$data->price}}">
                  </p>
                <p>
                  <input type="submit" value=@lang('common.save')>
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
