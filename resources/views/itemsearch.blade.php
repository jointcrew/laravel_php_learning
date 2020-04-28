
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('common.search')</div>
                <div>
                    <a href="/items">@lang('common.item_add')</a>
                    <br>
                    <a href="/itemList">@lang('common.item_list')</a>
                </div>
                <form action="/itemsearch" method="get">
                  <!-- CSRF保護 -->
                 @csrf
                  <p><!--商品名-->
                    @lang('item.name')：<input type="text" name="item_name" size="40" value="{{ old('item_name') }}<?php echo $request->input('item_name');?>">
                    @if ($errors->has('item_name'))
                        <br><span>{{ $errors->first('item_name')}}</span>
                    @endif
                  </p>
                  <p><!--valueで入力値維持させる -->
                    @lang('item.apply')：<select name='apply'><!--申請先-->
                      <option name="apply" value=1
                          @if(old('apply')=='1') selected  @endif
                          <?php if( !empty($_GET['apply']) && $_GET['apply']==="1"){ echo 'selected'; } ?>>@lang('item.apply1')</option>
                      <option name="apply" value=2
                          @if(old('apply')=='2') selected  @endif
                          <?php if( !empty($_GET['apply']) && $_GET['apply']==="2"){ echo 'selected'; } ?>>@lang('item.apply2')</option>
                      <option name="apply" value=3
                          @if(old('apply')=='3') selected  @endif
                          <?php if( !empty($_GET['apply']) && $_GET['apply']==="3"){ echo 'selected'; } ?>>@lang('item.apply3')</option>
                    </select>
                  </p>
                  <p><!--種別-->
                    @lang('item.selector')：
                    <input type="radio" name="selector" value=1
                        @if(old('selector')=='1') checked  @endif
                        <?php if( !empty($_GET['selector']) && $_GET['selector']==="1"){ echo 'checked'; } ?>>@lang('item.selector1')
                    <input type="radio" name="selector" value=2
                        @if(old('selector')=='2') checked  @endif
                        <?php if( !empty($_GET['selector']) && $_GET['selector']==="2"){ echo 'checked'; } ?>>@lang('item.selector2')
                    <input type="radio" name="selector" value=99
                        @if(old('selector')=='99') checked  @endif
                        <?php if( !empty($_GET['selector']) && $_GET['selector']==="99"){ echo 'checked'; } ?>>@lang('item.selector3')
                  </p>
                  <p><!--日付指定-->
                    <input type="date" name="date_start" value="{{ old('date_start') }}<?= $request->input('date_start');?>">
                    <a>～</a>
                    <input type="date" name="date_end" value="{{ old('date_end') }}<?= $request->input('date_end');?>">
                  </p>
                  <p><!--検索-->
                    <input type="submit" value= @lang('common.search')>
                  </p>
                </form>
                <div class="card-body">
                  <p style="color:red;"><?php if(isset($msg)){echo $msg;}?></p>
                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                              <p>@lang('common.search_list')</p>
                                <th>@lang('item.name')</th>
                                <th>@lang('item.apply')</th>
                                <th>@lang('item.selector')</th>
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
                                <td>{{$list->created_at}}</td>
                                <td>
                                    <a href="/itemEdit?itemId={{$list->item_id}}" class="btn btn-primary btn-sm">@lang('item.edit_link')</a>
                                    <!--GETで送る-->
                                    <a href="/itemDelete?itemId={{$list->item_id}}" class="btn btn-danger btn-sm">@lang('item.delete_link')</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $searchlist->appends($data)->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
