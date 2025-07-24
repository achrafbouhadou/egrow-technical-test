<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project' => $this->resource['project_name'],
            'total_issues' => $this->resource['total_issues'],
            'open_issues' => $this->resource['open_issues'],
            'assigned_to_issues' => $this->resource['assigned_to_issues'],
            'high_priority_unresolved' => $this->resource['high_priority_unresolved'],
        ];
    }
}
