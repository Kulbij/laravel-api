<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intersection extends Model
{
    use HasFactory;

    protected $fillable = [
        'referring_domain',
        'rank',
        'backlinks',
    ];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }
}
