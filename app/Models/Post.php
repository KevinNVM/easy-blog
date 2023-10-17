<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;

class Post extends \Stephenjude\FilamentBlog\Models\Post
{
    use HasFactory;

    public static function calculateReadingTime($content, $avgReadingSpeed = 225): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / $avgReadingSpeed);

        return $readingTime;
    }

    public function getReadingTime(): int
    {
        return $this->calculateReadingTime($this->content);
    }

    public function scopeFilter($query, array $filters = []): void
    {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('content', 'LIKE', "%$search%"));

        $query->when(
            $filters['category'] ?? false,
            fn($query, $category) =>
            $query
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                })
        );

        $query->when(
            $filters['author'] ?? false,
            fn($query, $author) =>
            $query->whereHas('author', function ($query) use ($author) {
                $query->where('name', 'LIKE', "%$author%");
            })
        );

        $query->when($filters['order'] ?? false, function ($query, $order) {
            switch ($order) {
                case "latest":
                    return $query->latest();
                    break;
                case "oldest":
                    return $query->oldest();
                    break;
                case "a-z":
                    return $query->orderBy('title', 'asc');
                    break;
                case "z-a":
                    return $query->orderBy('title', 'desc');
                    break;
                default:
                    return $query;
                    break;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}