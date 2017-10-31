@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="page-header">
            <h1>微信账号管理
                <small>群发列表</small>
            </h1>
        </div>
        <p>
            <a href="/groupsending/{{$id}}" type="button" class="btn btn-primary">添加群发任务</a>
        </p>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>类型</th>
                <th>内容</th>
                <th>成功次数</th>
                <th>失败次数</th>
                <th>开始发送时间</th>
                <th>完成时间</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr class="{{$v->status == 0?'active':($v->status == 1?'warning':'success')}}">
                    <td>{{$v->id}}</td>
                    <td>
                        @if($v->msg_type == 1)
                            文本
                        @elseif($v->msg_type == 2)
                            图片
                        @else
                            图文
                        @endif
                    </td>
                    <td>{{strlen($v->contents) > 50?substr($v->contents,0,50).'...':$v->contents}}</td>
                    <td>{{$v->success_count}}</td>
                    <td>{{$v->failed_count}}</td>
                    @if($v->start_time == '0000-00-00 00:00:00')
                        <td style="color: #f00">暂未开始</td>
                    @else
                        <td style="color: green">{{$v->start_time}}</td>
                    @endif
                    @if($v->complete_time == '0000-00-00 00:00:00' && $v->start_time != '0000-00-00 00:00:00')
                        <td style="color: green">正在进行中</td>
                    @elseif($v->complete_time == '0000-00-00 00:00:00' && $v->start_time == '0000-00-00 00:00:00')             <td style="color: #f00">暂未开始</td>
                    @else
                        <td style="color: blue">{{$v->complete_time}}</td>
                    @endif
                    <td>{{$v->create_time}}</td>
                    <td>
                        @if($v->status == 0)
                            <a href="/groupsending/send/{{$v->id}}" type="button" class="btn btn-success btn-xs">&nbsp;&nbsp;开始群发&nbsp;&nbsp;</a>
                        @elseif($v->status == 1)
                            <a type="button" class="btn btn-danger btn-xs">正在进行中</a>
                        @else
                            <a type="button" class="btn btn-primary btn-xs">&nbsp;&nbsp;&nbsp;&nbsp;已完成&nbsp;&nbsp;&nbsp;&nbsp;</a>
                        @endif
                            <br/>
                            <a href="/groupsending/task_logs/{{$v->id}}" type="button" class="btn btn-primary btn-xs">&nbsp;&nbsp;运行日志&nbsp;&nbsp;</a>
                            <br/>
                            <a href="/groupsending/details/{{$v->id}}" type="button" class="btn btn-primary btn-xs">&nbsp;&nbsp;显示详情&nbsp;&nbsp;</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
