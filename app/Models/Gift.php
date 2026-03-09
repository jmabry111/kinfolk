<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['contact_id', 'user_id', 'description', 'budget', 'url', 'is_public', 'is_purchased', 'purchased_by', 'on_christmas_list'];

    protected $casts = [
        'is_public' => 'boolean',
        'is_purchased' => 'boolean',
        'budget' => 'decimal:2',
        'on_christmas_list' => 'boolean',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchasedBy()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }
}
