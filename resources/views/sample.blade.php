@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">サンプルデータ登録</div>
                <div class="card-body">
                    {!! Form::open(['url' => 'sample']) !!}
                        <div class="form-group row">
                            {{Form::label('sample_name', __('sample.name'), ['class' => 'col-md-3 col-form-label'])}}
                            {{Form::text('sample_name', old('sample_name'), ['class' => 'col-md-9 form-control'])}}
                            @if($errors->has('sample_name'))
                                @foreach($errors->get('sample_name') as $message)
                                  <p class="offset-3 col-md-9 alert alert-danger">{{ $message }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group row">
                            {{Form::label('type', __('sample.type'), ['class' => 'col-md-3 col-form-label'])}}
                            <div class="col-md-9 form-inline">
                                @foreach( $type_array as $key => $value)
                                  <div class="form-inline">
                                    {{Form::radio('type' , $key , $key == old('type') ? true : $loop->first ? true : false , ['class' => 'form-control' , 'id' => 'type_'.$key ])}}
                                    {{Form::label('type'.$key , $value)}}
                                  </div>
                                @endforeach
                            </div>
                            @if($errors->has('type'))
                                @foreach($errors->get('type') as $message)
                                    <p class="offset-3 col-md-9 alert alert-danger">{{ $message }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group row">
                            {{Form::label('price', __('sample.price'), ['class' => 'col-md-3 col-form-label'])}}
                            {{Form::number('price', old('price'), ['class' => 'col-md-9 form-control'])}}
                            @if($errors->has('price'))
                                @foreach($errors->get('price') as $message)
                                  <p class="offset-3 col-md-9 alert alert-danger">{{ $message }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            {{Form::submit(__('sample.update_btn'), ['class' => 'btn btn-primary'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="mx-auto">
                    <a href="/sampleList">サンプル表示リンク</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
