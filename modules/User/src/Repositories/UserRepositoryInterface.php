<?php

namespace Modules\User\src\Repositories;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
  public function getAllUsers();
  public function getUsers($limit);
  public function setPassword($password, $id);
  public function checkPassword($password, $id);
}
