<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use \Stephenjude\FilamentBlog\Models\Post as FilamentPost;

class PostController extends Controller
{

    protected function calculateReadingTime($content, $avgReadingSpeed = 225): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / $avgReadingSpeed);

        return $readingTime;
    }

    public function welcome()
    {
        return view('welcome', [
            'posts' => Post::latest()
                ->whereNotNull('published_at')
                ->paginate(9)
        ]);
    }

    public function index()
    {
        return view('posts.index', [
            'posts' => Post::filter(request(['search', 'category', 'author', 'order']))
                ->whereNotNull('published_at')
                ->paginate(9)
                ->withQueryString(),
            'categories' => \Stephenjude\FilamentBlog\Models\Category::all()
        ]);
    }

    public function show(Post $post)
    {

        // Rekomendasi postingan dari author yang sama
        $sameAuthorPosts = collect();
        $count = 4;

        $sameAuthorPosts = $sameAuthorPosts->concat(
            $post
                ->where('blog_author_id', $post->author->id)
                ->whereNot('id', $post->id)
                ->latest()
                ->limit($count)
                ->get()
        );

        // Rekomendasi postingan yang recommended
        $relatedPosts = collect();

        $relatedPosts = $relatedPosts->concat(
            FilamentPost::withAnyTags(
                FilamentPost::find($post->id)->tags->pluck('name')
            )->whereNot('id', $post->id)->limit($count)->get()
        );

        // Rekomendasi postingan yang berada dalam kategori sama
        if ($relatedPosts->count() < $count) {
            $relatedPosts = $relatedPosts->concat(
                $post
                    ->where('blog_category_id', $post->category->id)
                    ->whereNot('id', $post->id)
                    ->limit($count - $relatedPosts->count())
                    ->get()
            );
        }

        // Rekomendasi postingan yang random
        if ($relatedPosts->count() < $count) {
            $relatedPosts = $relatedPosts->concat(
                $post
                    ->inRandomOrder()
                    ->whereNot('id', $relatedPosts->pluck('id')->toArray())
                    ->limit($count - $relatedPosts->count())
                    ->get()
            );
        }

        return view('posts.show', [
            'post' => $post,
            'same_author_posts' => $sameAuthorPosts,
            'related_posts' => $relatedPosts,
            // 'readingTime' => $this->calculateReadingTime($post->content)
        ]);
    }
}