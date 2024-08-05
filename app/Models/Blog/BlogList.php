<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogList extends Model
{
    use HasFactory;

    protected $table = 'blog_list';

    protected $fillable = [
        'article_title',
        'article_meta_title',
        'article_meta_description',
        'slug',
    ];
}
