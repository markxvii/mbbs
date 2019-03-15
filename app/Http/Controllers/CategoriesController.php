<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request,User $user,Link $link)
    {
        $builder=Topic::query()->where('category_id',$category->id);
        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            if ($order == 'recent') {
                $builder->orderBy('updated_at', 'desc');
            } else {
                $builder->orderBy('created_at', 'desc');
            }
        }

        $topics = $builder->paginate(20);
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
        return view('topics.index', ['topics' => $topics,'category'=>$category,'active_users'=>$active_users,'links'=>$links]);
    }
}
