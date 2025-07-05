<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_active',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }

    /**
     * 排班明細
     */
    public function scheduleDetails(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class);
    }

    /**
     * 檢查是否為啟用狀態
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * 取得班別顏色（從 metadata 中）
     */
    public function getColor(): string
    {
        return $this->metadata['color'] ?? '#3498db';
    }

    /**
     * 取得班別圖示（從 metadata 中）
     */
    public function getIcon(): string
    {
        return $this->metadata['icon'] ?? 'clock';
    }
}
