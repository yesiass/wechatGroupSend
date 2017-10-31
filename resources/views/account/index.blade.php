@extends('layouts.app')

@section('content')
        <div class="row" >
            <div class="page-header">
                <h1>微信账号管理
                    <small>微信账号列表</small>
                </h1>
            </div>
            <p>
                <a href="/account/add" type="button" class="btn btn-primary">添加账号</a>
            </p>
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>登录账号</th>
                    <th>AppId</th>
                    <th style="width: 40%">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->account}}</td>
                    <td>{{$v->appid}}</td>
                    <td>
                        <a href="/account/reply/{{$v->id}}" type="button" class="btn btn-success btn-xs">账号关注回复</a>
                        <a href="/customerservice/{{$v->id}}" type="button" class="btn btn-success btn-xs">关注定时消息</a>
                        <a href="/groupsending/list/{{$v->id}}" type="button" class="btn btn-success btn-xs">群发消息</a>
                        <a href="/account/save/{{$v->id}}" type="button" class="btn btn-primary btn-xs">修改</a>
                        <a href="javascript:if (confirm('是否需要删除?')) location='/account/del/{{$v->id}}';" type="button" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
@endsection
