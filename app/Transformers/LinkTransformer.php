<?php
/**
 * Created by PhpStorm.
 * User: Marc Yin
 * Date: 2019-03-26
 * Time: 21:21
 */

namespace App\Transformers;
use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id' => $link->id,
            'title' => $link->title,
            'link' => $link->link,
        ];
    }
}