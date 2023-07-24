<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class Channel extends Model
{
    use HasFactory, SchemalessAttributesTrait, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'youtube_channels';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'channel_id',
        'total_subscribers',
        'total_videos',
        'total_views',
        'total_likes',
        'total_comments',
        'total_engagement',
        'weekly_cadence',
        'monthly_cadence',
        'average_views',
        'average_likes',
        'average_comments',
        'average_engagement',
        'view_comment_ratio',
        'view_engagement_ratio',
        'view_like_ratio',
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
     * A channel belongs to a report.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Get the videos for the channel.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
