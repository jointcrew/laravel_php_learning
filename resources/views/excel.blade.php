@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!--購入メッセージ-->
            @if (isset($msg))
                <div class="card">
                    <div class="card-header">@lang('common.resalt')</div>
                    <div class="col-md-12 justify-content-center">
                        <span class="red">{{$msg}}</span>
                    </div>
                </div>
                <br>
            @endif
            <div class="card">
                <div class="card-header">Excelデータ出力</div>
                    <div class="card-body">
                        <div class="container">
                            <a href="/export"　class="btn btn-primary">@lang('excel.excel_export')</a>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>@lang('excel.last_name')</th>
                                        <th>@lang('excel.name')</th>
                                        <th>@lang('excel.last_name_kana')</th>
                                        <th>@lang('excel.name_kana')</th>
                                        <th>@lang('excel.gender')</th>
                                        <th>@lang('excel.birthday_day')</th>
                                    </tr>
                                </thead>
                                    @foreach ($userlist as $list)
                                        <tr>
                                            <td>{{$list["last_name"]}}</td>
                                            <td>{{$list["name"]}}</td>
                                            <td>{{$list["last_name_kana"]}}</td>
                                            <td>{{$list["name_kana"]}}</td>
                                            <td>@lang("excel.gender_number.{$list['gender']}")</td>
                                            <td>{{$list["birthday_day"]}}</td>
                                        </tr>
                                    @endforeach
                            </table>
                            {{ $userlist->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
