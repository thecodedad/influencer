<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class Video extends Model
{
    use HasFactory, SchemalessAttributesTrait, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'youtube_videos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'video_id',
        'total_views',
        'total_likes',
        'total_comments',
        'details',
        'statistics',
        'published_at',
    ];

    /**
     * The attributes that should be cast as schemaless.
     */
    protected $schemalessAttributes = [
        'details',
        'statistics',
    ];

    /**
     * Get the channel that owns the video.
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
