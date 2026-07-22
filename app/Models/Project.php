<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function completionPercentage(): int
    {
        $total = $this->tasks()->count();

        if ($total === 0) {
            return 0;
        }

        $completed = $this->tasks()->where('status', 'completed')->count();

        return (int) round(($completed / $total) * 100);
    }

    public function syncStatusFromTasks(): void
    {
        $totalTasks = $this->tasks()->count();

        if ($totalTasks === 0) {
            return; // no tasks yet — leave status as-is (likely 'active' from creation)
        }

        $completedTasks = $this->tasks()->where('status', 'completed')->count();

        $newStatus = ($completedTasks === $totalTasks) ? 'completed' : 'active';

        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }

}