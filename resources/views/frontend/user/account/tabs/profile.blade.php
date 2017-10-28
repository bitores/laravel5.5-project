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

                  <button class="layui-btn" id="upload" style="display: none;">����ϴ�ͼƬ</button>
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
                  ,auto: false //ѡ���ļ����Զ��ϴ�
                  ,bindAction: '#upload' //ָ��һ����ť�����ϴ�
                  ,accept:'images'
                  ,exts:'jpg|png|gif|jpeg'
                  ,size:500
                  ,choose: function(obj){
                    //��ÿ��ѡ����ļ�׷�ӵ��ļ�����
                    var files = obj.pushFile();
                    
                    //Ԥ�������ļ�������Ƕ��ļ�����������(��֧��ie8/9)
                    obj.preview(function(index, file, result){
                      // console.log(index); //�õ��ļ�����
                      // console.log(file); //�õ��ļ�����
                      // console.log(result); //�õ��ļ�base64���룬����ͼƬ
                      $('.layui-upload-img').attr('src', result);

                      $("#upload").show();
                      //���ﻹ������һЩ append �ļ��б� DOM �Ĳ���
                      
                      //obj.upload(index, file); //���ϴ�ʧ�ܵĵ����ļ������ϴ���һ����ĳ���¼���ʹ��
                      // delete files[index]; //ɾ���б��ж�Ӧ���ļ���һ����ĳ���¼���ʹ��
                    });
                  }
                ,done: function(response){
                    layer.msg(response.msg);
                    //�ϴ��ɹ�
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