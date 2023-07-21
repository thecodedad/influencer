<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class Report extends Model
{
    use HasFactory, SchemalessAttributesTrait, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'youtube_reports';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'channels',
        'videos',
    ];

    /**
     * The attributes that should be cast as schemaless.
     */
    protected $schemalessAttributes = [
        'channels',
        'videos',
    ];

    /**
     * A report belongs to many channels.
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Channel::class,
            table: 'youtube_report_channels',
            foreignPivotKey: 'report_id',
            relatedPivotKey: 'channel_id',
            parentKey: 'id',
            relatedKey: 'id',
        );
    }
}
