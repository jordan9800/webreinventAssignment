<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all($attributes = []): Collection;

    public function get($id): ?Task;

    public function store($attributes = []): bool;

    public function update($id, $attributes = []): bool;

    public function delete($id): Task|bool;

    public function restore($id): Task|bool;
}
