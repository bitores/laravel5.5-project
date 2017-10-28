<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Config;
use App\Http\Requests\Frontend\User\AccountRequest;
use App\Repositories\Frontend\Access\User\UserRepository;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
	public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.account');
    }

    /**
     * @description:�ϴ�ͷ��
     * @author wuyanwen(2017��9��20��)
     * @param Request $request
     */
    public function uploadAvatar(AccountRequest $request)
    {	
    	// echo "string"  . $rr  . $ss;
    	// Request $request;
        

        if ($request->hasFile('file')) {
            $file =  $request->file('file');
            
            $path = $file->store('avatars');
            
            $avatar = Config::get('filesystems.disks.images.root') . '/avatars';

            $file->move($avatar,$path);

            $this->user->changeAvatar('/img/'.$path);
            return ['code' => 0,'msg' => '�ϴ��ɹ�'];
        } else {
            return ['code'=>-1, 'msg' => '�ϴ�ʧ��'];
        }
    }
}
