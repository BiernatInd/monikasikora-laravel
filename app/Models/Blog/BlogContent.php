<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContent extends Model
{
    use HasFactory;

    protected $table = 'blog_content';

    protected $fillable = [
        'article_type',
        'article_text',
        'article_number',
        'slug',
    ];
}
