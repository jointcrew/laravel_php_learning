@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                  <h1 style="font-size:25px;">
                    PHP study
                  </h1>
                  <form action="/" method="post">
                    <p>
                      商品名：<input type="text" name="item" size="40">
                    </p>
                    <p>
                      申請先：<select name="address">
                        <option value="JC">JC社内</option>
                      </select>
                    </p>
                    <p>
                      性別：<input type="radio" name="type">備品
                      <input type="radio" name="type">私物
                    </p>
                    <p>
                      価格：<input type="text" name="price" size="40">
                    </p>
                    <p>
                      <input type="submit" value="保存">
                    </p>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
