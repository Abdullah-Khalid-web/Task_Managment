<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'project_id',
        'parent_id',
        'title',
        'description',
        'status',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    /**
     * Relationships
     */

    // Project this task belongs to
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // User who created the task
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // User assigned to the task
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Parent task (for sub-tasks)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    // Sub-tasks
    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id')->with('subtasks');
    }

    // Task remarks/comments
    public function remarks(): HasMany
    {
        return $this->hasMany(TaskRemark::class, 'task_id')->latest();
    }

    /**
     * Scopes
     */
    public function scopeMainTasks($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSubtasksOnly($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeAssignedToMe($query)
    {
        return $query->where('assigned_to', auth()->id());
    }

    /**
     * Status helpers
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-label-warning',
            self::STATUS_IN_PROGRESS => 'bg-label-info',
            self::STATUS_COMPLETED => 'bg-label-success',
            default => 'bg-label-secondary',
        };
    }

    /**
     * Get status text
     */
    public function getStatusText(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            default => 'Unknown',
        };
    }
}
