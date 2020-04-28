
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('common.list')</div>
                <div>
                    <a href="/items">@lang('common.item_add')</a>
                    <br>
                    <a href="/itemsearch">@lang('common.item_search')</a>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
                      <thead>
                          <tr>
                              <th>@lang('item.name')</th>
                              <th>@lang('item.apply')</th>
                              <th>@lang('item.type')</th>
                              <th>@lang('item.price')</th>
                              <th>@lang('item.create_user')</th>
                              <th>@lang('item.edit')</th>
                          </tr>
                      </thead>
                      @foreach($list as $item)
                          <tr>
                              <td>{{$item->item_name}}</td>
                              <td>@lang("item.apply_text.$item->apply")</td>
                              <td>@lang("item.selector_text.$item->selector")</td>
                              <td>{{$item->price}}</td>
                              <td>{{$item->create_user}}</td>
                              <td>
                                  <a href="/itemEdit?itemId={{$item->item_id}}" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                  <a href="/itemDelete?itemId={{$item->item_id}}" class="btn btn-danger btn-sm">@lang('item.delete_link')</a>
                              </td>
                          </tr>
                      @endforeach
                  </table>
                    {{ $list->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
