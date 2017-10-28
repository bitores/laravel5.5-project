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
     * @description:上传头像
     * @author wuyanwen(2017年9月20日)
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
            return ['code' => 0,'msg' => '上传成功'];
        } else {
            return ['code'=>-1, 'msg' => '上传失败'];
        }
    }
}
