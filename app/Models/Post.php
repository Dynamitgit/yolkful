<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $image
 * @property string $status
 * @property int $user_id
 * @property int $category_id
 * @property int $views
 */
class Post extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'image', 'status', 'user_id', 'category_id', 'collection_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}