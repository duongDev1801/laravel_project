<?php

namespace App\Repositories;

abstract class BaseRepository implements RepositoryInterface
{
  protected $model;

  public function __construct()
  {
    $this->setModel();
  }

  public function setModel()
  {
    $this->model = app()->make($this->getModel());
  }

  abstract public function getModel();
  public function getAll()
  {
    return $this->model->all();
  }

  public function find($id)
  {
    $result = $this->model->find($id);
    return $result;
  }

  public function create($attributes = [])
  {
    return $this->model->create($attributes);
  }

  public function update($id, $attributes = [])
  {
    $result = $this->find($id);
    if ($result) {
      return $result->update($attributes);
    }
    return false;
  }

  public function delete($id)
  {
    $result = $this->find($id);
    if ($result) {
      $result->delete();
      return true;
    }
    return false;
  }
}
