<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'news_id',
        'user_id',
        'parent_id',
        'comment',
    ];

    /**
     * Get the news item that owns the comment.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment (for replies).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NewsComment::class, 'parent_id');
    }

    /**
     * Get all replies to this comment.
     */
    public function replies()
    {
        return $this->hasMany(NewsComment::class, 'parent_id')->with('user.profile')->latest();
    }
}
