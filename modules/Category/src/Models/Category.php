<?php

namespace Modules\Category\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;
class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id'];
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Quan hệ: Danh mục con.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
