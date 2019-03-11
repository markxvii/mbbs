<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request)
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
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		return view('topics.create_and_edit', compact('topic'));
	}

	public function store(TopicRequest $request)
	{
		$topic = Topic::create($request->all());
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}