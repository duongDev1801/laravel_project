<?php

namespace Modules\Category\src\Repositories;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
  public function getAllCategories();
}