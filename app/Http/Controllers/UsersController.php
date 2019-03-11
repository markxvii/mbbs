<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //中间件
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);//或only
    }

    //用户详情页面get
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    //用户资料编辑页面get
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', ['user' => $user]);
    }

    //用户资料提交逻辑patch
    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect() ->route('users.show', $user->id)->with('success', '资料更新成功！');
    }
}
