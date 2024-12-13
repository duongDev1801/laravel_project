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


  public function getCategories()
  {
    return $this->model->select('*')->latest();
  }
  public function getAllCategories()
  {
    return $this->getCategories()->get();
  }
}
