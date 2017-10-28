<table class="table table-striped table-hover">
    <tr>
        <th>{{ trans('labels.frontend.user.profile.avatar') }}</th>
        <td>
            <!-- <img src="{{ $logged_in_user->picture }}" class="user-profile-image" /> -->
            <div class="form">
                <div class="layui-upload" style="width:80%;margin:0 auto;padding-bottom:20px;">
                  <div class="layui-upload-list">
                    <img class="layui-upload-img" src="{{ $logged_in_user->picture }}" id="avatar" style="width:150px;height:150px;">
                  </div>

                  <button class="layui-btn" id="upload" style="display: none;">点击上传图片</button>
                </div> 
            </div>
            <script src="{{ asset('/js/layui/layui.js') }}"></script>
            <script>
            layui.use(['element','jquery','upload'], function(){
              var element = layui.element
                        $ = layui.jquery
                  upload  = layui.upload;
                
              upload.render({
                  elem: '#avatar'
                  ,url: '/uploadAvatar'
                  ,method:'post'
                  ,auto: false //选择文件后不自动上传
                  ,bindAction: '#upload' //指向一个按钮触发上传
                  ,accept:'images'
                  ,exts:'jpg|png|gif|jpeg'
                  ,size:500
                  ,choose: function(obj){
                    //将每次选择的文件追加到文件队列
                    var files = obj.pushFile();
                    
                    //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
                    obj.preview(function(index, file, result){
                      // console.log(index); //得到文件索引
                      // console.log(file); //得到文件对象
                      // console.log(result); //得到文件base64编码，比如图片
                      $('.layui-upload-img').attr('src', result);

                      $("#upload").show();
                      //这里还可以做一些 append 文件列表 DOM 的操作
                      
                      //obj.upload(index, file); //对上传失败的单个文件重新上传，一般在某个事件中使用
                      // delete files[index]; //删除列表中对应的文件，一般在某个事件中使用
                    });
                  }
                ,done: function(response){
                    layer.msg(response.msg);
                    //上传成功
                    $("#upload").hide();
                }
                ,error: function(response){
                    // layer.msg(response);
                }
                });      

            });
            </script>

        </td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.name') }}</th>
        <td>{{ $logged_in_user->name }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.email') }}</th>
        <td>{{ $logged_in_user->email }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.created_at') }}</th>
        <td>{{ $logged_in_user->created_at }} ({{ $logged_in_user->created_at->diffForHumans() }})</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_updated') }}</th>
        <td>{{ $logged_in_user->updated_at }} ({{ $logged_in_user->updated_at->diffForHumans() }})</td>
    </tr>
</table>