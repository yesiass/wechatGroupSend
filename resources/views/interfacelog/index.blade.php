@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="page-header">
            <h1>微信账号管理
                <small>接口日志</small>
            </h1>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>账户</th>
                <th>获取用户列表(次)</th>
                <th>发送客服消息(次)</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->account}}</td>
                    <td>{{$v->get_user_list}}</td>
                    <td>{{$v->send_kf_msg}}</td>
                    <td>{{$v->day}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
