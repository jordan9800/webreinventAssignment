<?php

namespace App\Http\Resources\Task;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        if (isset($this->created_at)) {
            $this->resource->created = Carbon::parse($this->created_at)->format('Y-m-d');
            unset($this->resource->created_at);
        }

        if (isset($this->deleted_at)) {
            $this->resource->deleted = Carbon::parse($this->deleted_at)->format('Y-m-d');
            unset($this->resource->deleted_at);
        }

        return $this->resource;
    }
}
