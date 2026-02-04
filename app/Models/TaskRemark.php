<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskRemark extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'task_id',
        'user_id',
        'remark',
        'attachment_path',
    ];

    /**
     * Relationships
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if remark has attachment
     */
    public function hasAttachment(): bool
    {
        return !empty($this->attachment_path);
    }

    /**
     * Get attachment URL
     */
    public function getAttachmentUrl(): ?string
    {
        if ($this->hasAttachment()) {
            return asset('storage/' . $this->attachment_path);
        }
        return null;
    }

    /**
     * Get attachment filename
     */
    public function getAttachmentFilename(): ?string
    {
        if ($this->hasAttachment()) {
            return basename($this->attachment_path);
        }
        return null;
    }
}
