@extends('master')
@section('content')
<div class="container custom-login">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <form action="login" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail">帳號</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="請填寫帳號">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">密碼</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="請輸入密碼">
                </div>
                <button type="submit" class="btn btn-default">登入</button>
            </form>
        </div>
    </div>
</div>
@endsection
