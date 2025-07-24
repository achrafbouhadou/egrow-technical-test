<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Models\Issue;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Issue::with('project');

        if ($request->has('status')) {
            $query->byStatus($request->query('status'));
        }

        if ($request->has('priority')) {
            $query->byPriority($request->query('priority'));
        }

        if ($request->has('assigned_to')) {
            $query->assignedTo($request->query('assigned_to'));
        }

        if ($request->has('project_id')) {
            $query->byProject($request->query('project_id'));
        }

        $issues = $query
            ->orderByPriority()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return $this->collectionResponse(
            IssueResource::collection($issues)
        );
    }
}