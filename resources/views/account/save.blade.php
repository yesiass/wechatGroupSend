@extends('layouts.app')

@section('content')
        <div class="row" >
            <div class="page-header">
                <h1>微信账号管理
                    <small>修改微信账号</small>
                </h1>
            </div>
            <form method="post" action="" class="form-horizontal" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">账号名称</label>
                    <div class="col-sm-3">
                        <input type="text" value="{{$data->account}}" name="account" class="form-control"  placeholder="请输入名称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-3">
                        <input type="password" value="{{$data->passwd}}" name="passwd" class="form-control"  placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">appid</label>
                    <div class="col-sm-3">
                        <input type="text" value="{{$data->appid}}" name="appid" class="form-control"  placeholder="appid">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">appsecret</label>
                    <div class="col-sm-3">
                        <input type="text" value="{{$data->appsecret}}" name="appsecret" class="form-control"  placeholder="appsecret">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">保存</button>
                    </div>
                </div>
            </form>
        </div>
@endsection
