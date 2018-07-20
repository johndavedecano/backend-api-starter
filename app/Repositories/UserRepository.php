<?php namespace App\Repositories;

use App\User\Models;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Repositories\Traits\FindOrFail;

/**
 * UserRepository
 */
class UserRepository extends Repository
{
    use FindOrFail;

    /**
     * Returns the model to be used by repository
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}