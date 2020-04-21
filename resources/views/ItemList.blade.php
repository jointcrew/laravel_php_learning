
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('sample.title')</div>
                <div>
                    <a href="/items">＜ 戻る</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>@lang('sample.name')</th>
                                <th>@lang('sample.apply')</th>
                                <th>@lang('sample.type')</th>
                                <th>@lang('sample.price')</th>
                                <th>@lang('sample.create_user')</th>
                                <th>@lang('sample.edit')</th>
                            </tr>
                        </thead>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->item_name}}</td>
                                <td>{{$item->apply}}</td>
                                <td>{{$item->selector}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->create_user}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">@lang('sample.edit_link')</a>
                                    <a href="#" class="btn btn-danger btn-sm">@lang('sample.delete_link')</a>
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
