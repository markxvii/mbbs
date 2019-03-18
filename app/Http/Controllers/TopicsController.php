<?php

namespace App\Http\Controllers;

use App\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('email_verified', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,User $user,Link $link)
	{
	    $builder=Topic::query();
	    // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索Topics
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            //模糊搜索帖子标题、内容、作者
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('body', 'like', $like)
                    ->orWhereHas('user', function ($query) use ($like) {
                        $query->where('name', 'like', $like);
                    })
                    ->orWhereHas('category', function ($query) use ($like) {
                        $query->where('name', 'like', $like);
                    });
            });
        }
        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            if ($order == 'recent') {
                $builder->orderBy('updated_at', 'desc');
            } else {
                $builder->orderBy('created_at', 'desc');
            }
        }


		$topics = $builder->with('user','category')->paginate(30);
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
		return view('topics.index', compact('topics','active_users','links'));
	}

    public function show(Request $request,Topic $topic)
    {
        //URL矫正
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();

		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = \Auth::id();
        $topic->save();
		return redirect()->to($topic->link())->with('message', '发送成功！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化返回数据
        $data = [
            'success'=>false,
            'msg' => '上传失败！',
            'file_path'=>''
        ];
        //判断是否有上传文件
        if ($file = $request->upload_file) {
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = '上传成功！';
                $data['success'] = true;
            }
        }
        return $data;
    }
}