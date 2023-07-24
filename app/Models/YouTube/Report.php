<?php

namespace App\Models\YouTube;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'data',
    ];

    /**
     * The attributes that should be cast as schemaless.
     */
    protected $schemalessAttributes = [
        'data',
    ];

    /**
     * A report has many channels.
     */
    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }
}
