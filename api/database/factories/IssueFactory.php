<?php

namespace Database\Factories;

use App\Enums\IssuesPriority;
use App\Enums\IssuesStatus;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        $issueStatus = IssuesStatus::values();
        $issuePriority = IssuesPriority::values();
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(1, true),
            'status' => $this->faker->randomElement($issueStatus),
            'priority' => $this->faker->randomElement($issuePriority),
            'assigned_to' => $this->faker->words(1, true),
        ];
    }
}