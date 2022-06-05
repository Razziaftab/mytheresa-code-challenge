<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'discountable_type', 'discountable_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'discountable_type',
        'discountable_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the parent discountable model (Product or Category).
     *
     * @return MorphTo
     */
    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }
}
