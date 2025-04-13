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
     * 獲取父分類的外鍵名稱
     */
    public function getParentKeyName(): string
    {
        return 'parent_id';
    }

    /**
     * 獲取子分類
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, $this->getParentKeyName())
                    ->where('is_active', true)
                    ->orderBy('sort');
    }

    /**
     * 獲取父分類
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, $this->getParentKeyName())
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

    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->parent_id === $category->id) {
                $category->parent_id = null;
            }
        });
    }
}