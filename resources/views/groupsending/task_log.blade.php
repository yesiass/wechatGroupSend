@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="page-header">
            <h1>微信账号管理
                <small>群发日志</small>
            </h1>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>等级</th>
                <th>信息</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->level}}</td>
                    <td>{{$v->infos}}</td>
                    <td>{{$v->create_time}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
