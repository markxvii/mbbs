<?php

namespace App\Models;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id','excerpt', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            //XSS注入
            $model->body = clean($model->body, 'user_topic_body');
            //话题摘录
            $model->excerpt = make_excerpt($model->body);
        });

        static::saved(function ($model) {
            //如slug字段无内容，即对title进行翻译
            if (!$model->slug) {
                dispatch(new TranslateSlug($model));
            }
        });
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
