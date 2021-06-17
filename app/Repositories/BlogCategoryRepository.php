<?php


namespace App\Repositories;

use App\Models\BlogCategory as Model;


/**
 * Class BlogCategoryRepository
 * @package App\Repositories
 *
 */

class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке
     * @param $id
     * @return mixed
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список категорий для вывода в выпадающий список
     * @return mixed
     *
     *
     */
    public function getForComboBox()
    {
        $fileds = implode(', ', [
            'id',
            'CONCAT (id,". ", title) AS id_title'
            ]);

         $result = $this
            ->startConditions()
            ->selectRaw($fileds)
            ->toBase()
            ->get();

         return $result;
    }

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }

}
