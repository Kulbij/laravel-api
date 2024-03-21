<?php

namespace App\Models;

use App\Models\Intersection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public const SUCCESS_STATUS = 'success';
	
	/**
     * @var string
     */
    public const ERROR_STATUS = 'error';

    /**
     * @var array
     */
    protected $casts = [
        'excluded_target' => 'array'
    ];

    protected $fillable = [
        'excluded_target',
        'target_domain',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intersections(): HasMany
    {
        return $this->hasMany(Intersection::class);
    }
}
