<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $validated)
 * @method static where(string $string, mixed $input)
 * @method static findOrFail($categoryId)
 */
class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable=[
        'category_name'
    ];


    public function blogs(): HasMany
    {
        return $this->hasMany(Blogs::class);
    }

}
