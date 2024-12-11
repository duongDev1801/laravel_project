<?php

namespace Modules\Category\src\Repositories;

use Modules\Category\src\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
  public function getModel()
  {
    return Category::class;
  }
  public function getProduct()
  {
    return $this->model->select('*')->take(5)->get();
  }

  public function getAllCategories()
  {
    return $this->model::with('parent')->select('*');
  }
}
