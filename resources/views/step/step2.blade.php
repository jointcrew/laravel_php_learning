@extends('layouts.app')
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
<script src=" js/step.js?<?= strtotime('now') ?> " defer></script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">step</div>
                <div class="card-body">
                    @include('layouts.step')
                    <div class="form-group mt-3">
                        <a id='pdf_display' href="#" class="btn btn-outline-success">PDF表示</a>
                    </div>
                    @if(Session::has('flash_message'))
                    <!-- モーダルウィンドウの中身 -->
                    <div class="modal fade" id="myModal" tabindex="-1"
                         role="dialog" aria-labelledby="label1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    {{ session('flash_message') }}
                                </div>
                                <div class="modal-footer text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 mt-3">
                            <a class="btn btn-outline-primary" href="/step1">@lang('common.back')</a>
                        </div>
                        <div class="col-md-3 mt-3">
                            <a class="btn btn-primary" href="/step3">@lang('common.next')</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
