@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">@lang('change_year.title')</div>
                <div class="card-body">
                    <form class="" action="/changeYear" method="post">
                        <!-- CSRF保護 -->
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-2">
                                @lang('change_year.year')：
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="number" name="year" value="">
                            </div>
                            <div class="col-md-2">
                                <input type="submit" name="" value="@lang('change_year.change')" class="btn btn-primary">
                            </div>
                            <div class="col-md-2">
                                @lang('change_year.japanese_year')：
                            </div>
                            @if (isset($era_name))
                                @if (isset($era_year))
                                    {{$era_name}}{{$era_year}}@lang('change_year.nen')
                                @endif
                                @if (!isset($era_year))
                                    {{$era_name}}@lang('change_year.first_nen')
                                @endif
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
