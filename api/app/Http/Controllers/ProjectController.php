<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectSummaryResource;
use App\Models\Project;
use App\Models\Issue;
use App\Enums\IssueStatus;
use App\Enums\IssuesPriority;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponseTrait;

    public function issuesSummary(Request $request, Project $project): JsonResponse
    {
        $totalIssues = $project->issues()->count();
        $openIssues = $project->issues()->open()->count();
        $assignedToIssues = 0;
        if ($request->has('assigned_to')) {
            $assignedToIssues = $project->issues()
                ->assignedTo($request->query('assigned_to'))
                ->count();
        }

        $highPriorityUnresolved = $project->issues()
            ->highPriority()
            ->unresolved()
            ->count();

        $summaryData = [
            'project_name' => $project->name,
            'total_issues' => $totalIssues,
            'open_issues' => $openIssues,
            'assigned_to_issues' => $assignedToIssues,
            'high_priority_unresolved' => $highPriorityUnresolved,
        ];

        return $this->resourceResponse(
            new ProjectSummaryResource($summaryData),
        );
    }
}