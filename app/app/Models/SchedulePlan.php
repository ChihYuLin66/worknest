<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchedulePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'month',
        'status',
        'created_by',
        'published_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    /**
     * 創建者
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * 排班明細
     */
    public function scheduleDetails(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class);
    }

    /**
     * 檢查是否為草稿狀態
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * 檢查是否已發布
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * 檢查是否已歸檔
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * 發布排班計劃
     */
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * 歸檔排班計劃
     */
    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }
}
