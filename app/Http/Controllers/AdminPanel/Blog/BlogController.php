<?php

namespace App\Http\Controllers\AdminPanel\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogList;
use App\Models\Blog\BlogContent;

class BlogController extends Controller
{
    public function addBlogPost(Request $request)
    {
        $request->validate([
            'article_title' => 'required|string',
        ]);

        $articles = new BlogList;
        $articles->article_title = $request->input('article_title');

        $latestSlug = BlogList::max('slug');
        $articles->slug = $latestSlug + 1;

        $articles->save();

        return response()->json(['message' => 'Wpis dodany pomyślnie', 'slug' => $articles->slug], 201);
    }

    public function addBlogMeta(Request $request, $slug)
    {
        $request->validate([
            'article_meta_title' => 'required|string',
            'article_meta_description' => 'required|string',
        ]);

        $article = BlogList::where('slug', $slug)->firstOrFail();
        $article->article_meta_title = $request->input('article_meta_title');
        $article->article_meta_description = $request->input('article_meta_description');
        $article->save();

        return response()->json(['message' => 'Meta tagi zaktualizowane pomyślnie', 'slug' => $article->slug], 200);
    }

    public function addBlogContent(Request $request)
    {
        $request->validate([
            'article_type' => 'required|string',
            'article_text' => 'required|string',
            'slug' => 'required|string',
        ]);

        $maxArticleNumber = BlogContent::where('slug', $request->slug)
            ->max('article_number');

        $articleNumber = $maxArticleNumber ? $maxArticleNumber + 1 : 1;

        $content = new BlogContent();
        $content->article_type = $request->article_type;
        $content->article_text = $request->article_text;
        $content->slug = $request->slug;
        $content->article_number = $articleNumber;
        $content->save();

        return response()->json(['message' => 'Treść dodana pomyślnie'], 200);
    }

    public function downloadBlogContent($slug)
    {
        $blogContents = BlogContent::where('slug', $slug)->get();
        return response()->json($blogContents);
    }

    public function editBlogContent(Request $request, $slug)
    {
        $blogContent = BlogContent::where('slug', $slug)
            ->where('article_number', $request->article_number)
            ->firstOrFail();

        $blogContent->update([
            'article_text' => $request->article_text,
        ]);

        return response()->json(['message' => 'Treść zaktualizowana pomyślnie']);
    }

    public function downloadBlogList()
    {
        $articles = BlogList::all();

        return response()->json(['articles' => $articles]);
    }

    public function deleteBlogArticle($slug)
    {
        $article = BlogList::where('slug', $slug)->first();

        if (!$article) {
            return response()->json(['error' => 'Artykuł nie został znaleziony.'], 404);
        }

        BlogContent::where('slug', $slug)->delete();

        $article->delete();

        return response()->json(['message' => 'Artykuł oraz powiązane treści i obrazy zostały pomyślnie usunięte.']);
    }

    public function downloadBlogAllData()
    {
        $blogContents = BlogContent::all();
        $blogList = BlogList::all();

        foreach ($blogList as $blogItem) {
            if (strlen($blogItem->article_meta_description) > 100) {
                $blogItem->article_meta_description = substr($blogItem->article_meta_description, 0, 100) . "...";
            }
        }

        return response()->json([
            'blogContents' => $blogContents,
            'blogList' => $blogList,
        ]);
    }

    public function downloadBlogArticle($slug)
    {
        $blogContents = BlogContent::where('slug', $slug)->get();
        $blogList = BlogList::where('slug', $slug)->get();

        return response()->json([
            'blogContents' => $blogContents,
            'blogList' => $blogList,
        ]);
    }

    public function downloadBlogMeta($slug)
    {
        $article = BlogList::where('slug', $slug)->first();

        if (!$article) {
            return response()->json(['message' => 'Artykuł nie znaleziony'], 404);
        }

        return response()->json(['article' => $article], 200);
    }
}
