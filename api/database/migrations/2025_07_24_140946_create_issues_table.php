<?php

use App\Enums\IssuesPriority;
use App\Enums\IssuesStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $issueStatus = IssuesStatus::values();
        $issuePriority = IssuesPriority::values();
        Schema::create('issues', function (Blueprint $table) use ($issueStatus, $issuePriority) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description');
            $table->enum('status', $issueStatus)->default(IssuesStatus::Open->value);
            $table->enum('priority', $issuePriority)->default(IssuesPriority::Low->value);
            $table->string('assigned_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
