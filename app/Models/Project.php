<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasUuids;

    // UUID settings
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable fields
    protected $fillable = [
        'title',
        'starting_date',
        'end_date',
        'category',
        'created_by',
    ];

    // Date casting
    protected $casts = [
        'starting_date' => 'date',
        'end_date'      => 'date',
    ];

    /**
     * Category helpers (optional but clean)
     */
    const CATEGORY_PROJECT = 'project';
    const CATEGORY_MEETING = 'meeting';

    /**
     * Relationships
     */

    // Project creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
