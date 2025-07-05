<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'open_time',
        'close_time',
        'is_closed',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'open_time' => 'datetime:H:i',
            'close_time' => 'datetime:H:i',
            'is_closed' => 'boolean',
            'metadata' => 'array',
        ];
    }

    /**
     * 取得星期名稱
     */
    public function getDayName(): string
    {
        $days = [
            0 => '星期日',
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
        ];

        return $days[$this->day_of_week] ?? '未知';
    }

    /**
     * 檢查是否為營業日
     */
    public function isOpen(): bool
    {
        return !$this->is_closed;
    }
}
