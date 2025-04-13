<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = [
        'name',
        'parent_id',
        'sort',
        'is_active',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * 獲取子分類
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
                    ->where('is_active', true)
                    ->orderBy('sort');
    }

    /**
     * 獲取父分類
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')
                    ->where('is_active', true);
    }

    /**
     * 獲取該分類的所有商品
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)
                    ->where('is_active', true);
    }

    /**
     * 獲取分類的完整路徑名稱
     */
    public function getFullPathAttribute()
    {
        $path = collect([$this->name]);
        $currentCategory = $this;
        
        while ($currentCategory->parent) {
            $path->prepend($currentCategory->parent->name);
            $currentCategory = $currentCategory->parent;
        }
        
        return $path->join(' > ');
    }

    public function ancestors()
    {
        return $this->morphToAncestors();
    }

    public function descendants()
    {
        return $this->morphToDescendants()->orderBy('sort');
    }

    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->parent_id === $category->id) {
                $category->parent_id = null;
            }
        });
    }
}
