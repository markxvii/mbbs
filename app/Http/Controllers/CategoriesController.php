<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request)
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
        return view('topics.index', ['topics' => $topics,'category'=>$category]);
    }
}
