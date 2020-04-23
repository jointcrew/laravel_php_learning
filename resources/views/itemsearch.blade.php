
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('item.title')</div>
                <div>
                    <a href="/items">@lang('common.item_add')</a>
                    <br>
                    <a href="/itemList">@lang('common.item_list')</a>
                </div>
                <form action="/itemsearch" method="get">
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
                    <input type="radio" name="selector" value=99>@lang('item.selector3')
                  </p>
                  <p>
                    <input type="date" name="date_start">
                    <a>～</a>
                    <input type="date" name="date_end">
                  </p>
                  <p>
                    <input type="submit" value= @lang('common.search')>
                  </p>
                </form>
                <div class="card-body">
                    <table class="table table-striped table-hover">

                        <thead>

                            <tr>
                              <p>@lang('common.search_list')</p>
                                <th>@lang('item.name')</th>
                                <th>@lang('item.apply')</th>
                                <th>@lang('item.type')</th>
                                <th>@lang('item.price')</th>
                                <th>@lang('item.create_user')</th>
                                <th>@lang('item.create_at')</th>
                                <th>@lang('item.edit')</th>
                            </tr>
                        </thead>
                        @foreach($searchlist as $list)
                            <tr>
                                <td>{{$list->item_name}}</td>
                                <td>@lang("item.apply_text.$list->apply")</td>
                                <td>@lang("item.selector_text.$list->selector")</td>
                                <td>{{$list->price}}</td>
                                <td>{{$list->create_user}}</td>
                                <td>{{$list->create_at}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                    <a href="#" class="btn btn-danger btn-sm">@lang('item.delete_link')</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
