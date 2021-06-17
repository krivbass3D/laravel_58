<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
/**
 * Class CoreRepository
 * @package App\Repositories
 *
 *
 * Репоризотрий работы с сущностью
 * Может выдавать наборы данных
 * Не может создавать/изменять сущности
 *
 */

abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass();

    protected function startConditions()
    {
        return clone $this->model;
    }
}
