@extends('layouts.app')
@section('content')
    <div class="row" >
        <div class="page-header">
            <h1>群发消息
                <small>群发消息详情</small>
            </h1>
        </div>
        <form id="form" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">账号ID</label>
                <div class="col-sm-3">
                    <input type="text" readonly name="account" class="form-control" value="{{$id}}"  placeholder="请输入名称">
                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-sm-2 control-label">回复类型</label>
                <div class="col-sm-3">
                    <select id="msg_type" class="form-control" name="msg_type">
                        @if(isset($data))
                            <option {{$data->msg_type == 1?'selected="selected"':''}} value="1">文本</option>
                            <option {{$data->msg_type == 2?'selected="selected"':''}} value="2">图片</option>
                            <option {{$data->msg_type == 3?'selected="selected"':''}} value="3">图文</option>
                        @else
                            <option value="1">文本</option>
                            <option value="2">图片</option>
                            <option value="3">图文</option>
                        @endif
                    </select>
                </div>
            </div>

            <div id="type1" style="display: none" class="form-group">
                <label for="lastname" class="col-sm-2 control-label">文本内容</label>
                <div class="col-sm-10">
                    @if(isset($contents))
                        <textarea id="contents" rows="10" name="contents" class="form-control">{{$contents}}</textarea>
                    @else
                        <textarea id="contents" rows="10" name="contents" class="form-control"></textarea>
                    @endif
                </div>
            </div>

            <div id="type2" style="display: none" class="form-group">
                <label for="lastname" class="col-sm-2 control-label">图片</label>
                <div class="col-sm-10">
                    <div id="localImag">
                        @if(isset($media_id))
                            <img id="preview" src="{{env('APP_PUBLIC').$media_id['url']}}"  style="display: block;">
                        @else
                            <img id="preview" src=""  style="display: block;">
                        @endif
                    </div>
                    <td align="center" style="padding-top:10px;"><input class="form-control" type="file" name="file" id="doc" style="width:150px;" onchange="javascript:setImagePreview();"></td>
                    @if(isset($media_id))
                        <input value="{{$media_id['media_id']}}" id="media_id" name="media_id" type="hidden"/>
                    @else
                        <input id="media_id" name="media_id" type="hidden"/>
                    @endif
                </div>
            </div>

            <div id="type3" style="display: none" class="form-group">
                @if(isset($articles))
                    @for($i=0;$i<=7;$i++)
                        <p>
                            <button type="button" class="btn btn-primary">{{$i+1}}</button>
                        </p>
                        <label for="lastname" class="col-sm-2 control-label">图文消息标题</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{isset($articles[$i]['title'])?$articles[$i]['title']:''}}" name="Title" class="form-control">
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">图文消息描述</label>
                        <div class="col-sm-10">
                            <textarea rows="10" name="Description" class="form-control">{{isset($articles[$i]['description'])?$articles[$i]['description']:''}}</textarea>
                        </div>
                        <label for="lastname"  class="col-sm-2 control-label">图片</label>
                        <span>支持JPG、PNG格式，较好的效果为大图360*200，小图200*200</span>
                        <div class="col-sm-10">
                            <div>
                                <img id="image{{$i}}" src="{{isset($articles[$i]['picurl'])?$articles[$i]['picurl']:''}}"/>
                            </div>
                            <td align="center" style="padding-top:10px;"><input class="form-control" type="file" name="images"  style="width:150px;" onchange="javascript:uploadImg(this,'{{$i}}');"></td>
                            <input value="{{isset($articles[$i]['picurl'])?$articles[$i]['picurl']:''}}" id="PicUrl{{$i}}" type="hidden" name="PicUrl" class="form-control" >
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">点击图文消息跳转链接</label>
                        <div class="col-sm-10">
                            <input type="url" value="{{isset($articles[$i]['url'])?$articles[$i]['url']:''}}" name="Url" class="form-control">
                        </div>
                    @endfor
                @else
                    @for($i=0;$i<=7;$i++)
                        <p>
                            <button type="button" class="btn btn-primary">{{$i+1}}</button>
                        </p>
                        <label for="lastname" class="col-sm-2 control-label">图文消息标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="Title" class="form-control">
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">图文消息描述</label>
                        <div class="col-sm-10">
                            <textarea rows="10" name="Description" class="form-control"></textarea>
                        </div>
                        <label for="lastname"  class="col-sm-2 control-label">图片链接</label>
                        <span>支持JPG、PNG格式，较好的效果为大图360*200，小图200*200</span>
                        <div class="col-sm-10">
                            <input type="url" name="PicUrl" class="form-control" >
                        </div>
                        <label for="lastname" class="col-sm-2 control-label">点击图文消息跳转链接</label>
                        <div class="col-sm-10">
                            <input type="url" name="Url" class="form-control">
                        </div>
                    @endfor
                @endif
            </div>
        </form>
    </div>
    <script src="{{asset('/js/jquery-1.9.1.min.js')}}"></script>
    <script>
        $(function(){
            show_contents();
            $('#msg_type').change(function(){
                show_contents();
            });
        });

        function show_contents()
        {
            var type = document.getElementById('msg_type').value;
            switch (parseInt(type))
            {
                case 1:
                    $('#type1').show();
                    $('#type2').hide();
                    $('#type3').hide();
                    break;
                case 2:
                    $('#type2').show();
                    $('#type1').hide();
                    $('#type3').hide();
                    break;
                case 3:
                    $('#type3').show();
                    $('#type2').hide();
                    $('#type1').hide();
                    break;
            }
        }

        //下面用于图片上传预览功能
        function setImagePreview(avalue) {
            var docObj=document.getElementById("doc");

            var imgObjPreview=document.getElementById("preview");
            if(docObj.files &&docObj.files[0])
            {
//火狐下，直接设img属性
                imgObjPreview.style.display = 'block';
                //imgObjPreview.style.width = '150px';
                //imgObjPreview.style.height = '180px';
//imgObjPreview.src = docObj.files[0].getAsDataURL();

//火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
            }
            else
            {
//IE下，使用滤镜
                docObj.select();
                var imgSrc = document.selection.createRange().text;
                var localImagId = document.getElementById("localImag");
//必须设置初始大小
                //localImagId.style.width = "150px";
                //localImagId.style.height = "180px";
//图片异常的捕捉，防止用户修改后缀来伪造图片
                try{
                    localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                }
                catch(e)
                {
                    alert("您上传的图片格式不正确，请重新选择!");
                    return false;
                }
                imgObjPreview.style.display = 'none';
                document.selection.empty();
            }
            return true;
        }

        function uploadImg(this_img,id)
        {
            var formData = new FormData();
            formData.append("image", this_img.files[0]);
            formData.append("_token", '{{csrf_token()}}');
            $.ajax({
                url: '/uploadImg',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType:'json',
                success: function (result) {
                    if(result.eror){
                        alert("设置失败！");
                    }else{
                        document.getElementById('image'+id).src = '{{env('APP_PUBLIC')}}'+result.url;
                        document.getElementById('PicUrl'+id).value = '{{env('APP_PUBLIC')}}'+result.url;
                    }
                },
                error: function () {
                    alert("上传失败！");
                }
            });
        }




    </script>
@endsection
