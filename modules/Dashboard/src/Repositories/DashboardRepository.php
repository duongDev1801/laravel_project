<?php

namespace Modules\Dashboard\src\Repositories;

use Modules\Dashboard\src\Models\Dashboard;
use App\Repositories\BaseRepository;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{
  public function getModel()
  {
    return Dashboard::class;
  }
  public function getProduct()
  {
    return $this->model->select('*')->take(5)->get();
  }
}
