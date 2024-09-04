<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResourceCollection;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->all($request->all());
        $collection = (new TaskResourceCollection($tasks));

        return response()->json($collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $success = $this->taskRepository->store($request->all());

        if ($success) {
            return response()->json(['message' => 'Task Created Successfully!'], Response::HTTP_CREATED);
        }

        return response()->json(['message' => 'Task Creation Unsuccessfull!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $attributes = $request->all();
        $success = $this->taskRepository->update($id, $attributes);

        if ($success) {
            if (isset($attributes['completed']) && $attributes['completed'] == 1) {
                return response()->json(['message' => 'Task Marked As Completed!'], Response::HTTP_OK);
            }

            return response()->json(['message' => 'Task Updated Successfully!'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Task Update Unsuccessfull!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->taskRepository->delete($id);

        if ($success) {
            return response()->json(['message' => 'Task Deleted Successfully!'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Task Deletion Unsuccessfull!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $success = $this->taskRepository->restore($id);

        if ($success) {
            return response()->json(['message' => 'Task Restored Successfully!'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Task Restoration Unsuccessfull!'], Response::HTTP_BAD_REQUEST);
    }
}
