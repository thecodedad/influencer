<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'weekly_cadence',
        'monthly_cadence',
        'average_views',
        'average_likes',
        'average_comments',
        'details',
        'statistics',
        'published_at',
    ];

    /**
     * The attributes that should be cast as dates.
     */
    protected $dates = [
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
     * A channel belongs to many reports.
     */
    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Report::class,
            table: 'youtube_report_channels',
            foreignPivotKey: 'channel_id',
            relatedPivotKey: 'report_id',
            parentKey: 'id',
            relatedKey: 'id',
        );
    }

    /**
     * Get the videos for the channel.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
