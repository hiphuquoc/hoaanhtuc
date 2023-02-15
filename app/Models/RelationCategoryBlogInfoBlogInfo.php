<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationCategoryBlogInfoBlogInfo extends Model {
    use HasFactory;
    protected $table        = 'relation_category_blog_info_blog_info';
    protected $fillable     = [
        'category_info_id', 
        'blog_info_id'
    ];
    public $timestamps      = false;

    public static function insertItem($params){
        $id             = 0;
        if(!empty($params)){
            $model      = new RelationCategoryBlogInfoBlogInfo();
            foreach($params as $key => $value) $model->{$key}  = $value;
            $model->save();
            $id         = $model->id;
        }
        return $id;
    }

    public function infoCategory(){
        return $this->hasOne(\App\Models\CategoryBlog::class, 'id', 'category_blog_info_id');
    }

    public function infoBlog(){
        return $this->hasOne(\App\Models\Blog::class, 'id', 'blog_info_id');
    }
}
