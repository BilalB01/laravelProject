<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'order',
    ];

    /**
     * Get the category this FAQ belongs to.
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
