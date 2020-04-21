@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('sample.title')</div>

                <form action="items" method="post">
                  <!-- CSRF保護 -->
                 @csrf
                  <p>
                    @lang('sample.name')：<input type="text" name="item_name" size="40">
                  </p>
                  <p>
                    @lang('sample.apply')：<select name="apply">
                      <option value=1>@lang('sample.apply1')</option>
                      <option value=2>@lang('sample.apply2')</option>
                      <option value=3>@lang('sample.apply3')</option>
                    </select>
                  </p>
                  <p>
                    @lang('sample.type')：<input type="radio" name="selector" value=1>@lang('sample.type1')
                    <input type="radio" name="selector" value=2>@lang('sample.type2')
                  </p>
                  <p>
                    @lang('sample.price')：<input type="text" name="price" size="40">
                  </p>
                  <p>
                    <input type="submit" value="保存">
                  </p>
                </form>

                <div class="mx-auto">
                    <a href="/sampleList">サンプル表示リンク</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
