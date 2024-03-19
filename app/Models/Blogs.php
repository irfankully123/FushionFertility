<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static paginate(int $int)
 * @method static findOrFail(mixed $input)
 * @method static latest()
 * @method static where(string $string, $categoryId)
 */
class Blogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_category_id',
        'author_name',
        'image',
        'title',
        'content'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

}
