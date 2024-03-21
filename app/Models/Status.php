<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'statuses';

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'message',
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }

    /**
     * @param int $code
     *
     * @return null|\App\Models\Status
     */
    public static function findByCode(int $code): ?Status
    {
        return self::byCode($code)->first();
    }

    /**
     * @param int $code
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCode(Builder $query, int $code): Builder
    {
        return $query->where($this->table . '.code', $code);
    }
}
