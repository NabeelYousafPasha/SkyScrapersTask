<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $table = 'blogs';

    protected $primaryKey = "blog_id";

    protected $fillable = [
        'blog_title',
        'fk_blogger_id',
        'blog_description',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


//    functions relationships

    /*
     * Blog =>  belongsTo  => Blogger
     */
    public function blogs_blogger()
    {
        return $this->hasMany('App\Blogger', 'fk_blogger_id', 'id');
    }

}
