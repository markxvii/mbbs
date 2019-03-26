<?php
/**
 * Created by PhpStorm.
 * User: Marc Yin
 * Date: 2019-03-26
 * Time: 17:51
 */

namespace App\Transformers;
use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id'=>$category->id,
            'name'=>$category->name,
            'description'=>$category->description,
        ];
    }

}