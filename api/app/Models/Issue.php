<?php

namespace App\Models;

use App\Enums\IssuesPriority;
use App\Enums\IssuesStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
    ];

    protected $casts = [
        'status' => IssuesStatus::class,
        'priority' => IssuesPriority::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Query Scopes
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    public function scopeAssignedTo(Builder $query, string $username): Builder
    {
        return $query->where('assigned_to', $username);
    }

    public function scopeByProject(Builder $query, int $projectId): Builder
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', IssuesStatus::Open->value);
    }

    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->whereNot('status', IssuesStatus::Closed->value);
    }

    public function scopeHighPriority(Builder $query): Builder
    {
        return $query->where('priority', IssuesPriority::High->value);
    }

    public function scopeOrderByPriority(Builder $query): Builder
    {
        return $query->orderByRaw("CASE 
            WHEN priority = 'high' THEN 1 
            WHEN priority = 'medium' THEN 2 
            WHEN priority = 'low' THEN 3 
            END");
    }
}