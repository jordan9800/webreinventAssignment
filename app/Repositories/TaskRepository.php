<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all($attributes = []): Collection
    {
        $query = Task::query();

        if (isset($attributes['completed'])) {
            $query->where('completed', $attributes['completed']);
        }

        if (isset($attributes['deleted'])) {
            $query->withTrashed();
        }

        return $query->orderBy('created_at')->get();
    }

    public function get($id): ?Task
    {
        return Task::findOrFail($id);
    }

    public function store($attributes = []): bool
    {
        $success = Task::create([
            'name' => $attributes['name'],
        ]);

        return $success ? true : false;
    }

    public function update($id, $attributes = []): bool
    {
        $task = $this->get($id);
        $data = [];

        if (isset($attributes['completed'])) {
            $data['completed'] = $attributes['completed'];
        }

        if (isset($attributes['name'])) {
            $data['name'] = $attributes['name'];
        }
        $success = $task->update($data);

        return $success ? true : false;
    }

    public function delete($id): Task|bool
    {
        $task = $this->get($id);
        $success = $task->delete();

        return $success ? true : false;
    }

    public function restore($id): Task|bool
    {
        $success = Task::withTrashed()->where('id', $id)->restore();

        return $success ? true : false;
    }
}
