<?php namespace App\Repositories\Traits;

trait FindOrFail
{
    /**
     * Find a given resource then throw an exception if not found
     *
     * @param int $id
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return Model
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
