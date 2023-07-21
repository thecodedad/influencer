<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class Channel extends Model
{
    use HasFactory, SchemalessAttributesTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'channel_id',
        'details',
        'statistics',
    ];

    /**
     * The attributes that should be cast as schemaless.
     */
    protected $schemalessAttributes = [
        'details',
        'statistics',
    ];

    /**
     * Get the videos for the channel.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
