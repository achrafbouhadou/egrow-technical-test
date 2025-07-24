<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Issue;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory(5)->create()->each(function (Project $project) {
            Issue::factory(3)->create(['project_id' => $project->id , 'status' => 'open']);
            Issue::factory(4)->create(['project_id' => $project->id , 'status' => 'in_progress']);
            Issue::factory(3)->create(['project_id' => $project->id , 'status' => 'resolved']);
            Issue::factory(2)->create(['project_id' => $project->id , 'status' => 'closed']);
            
            Issue::factory(2)->create(['project_id' => $project->id , 'priority' => 'high']);
            Issue::factory(1)->create(['project_id' => $project->id , 'priority' => 'low']);
        });

    }
}