<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    use HasFactory;

    protected $fillable = ['family_group_id', 'added_by', 'name', 'relationship_type', 'birthday', 'interest_tags', 'is_kin', 'birth_year_unknown', 'generation'];

    protected $casts = [
        'birthday' => 'date',
        'interest_tags' => 'array',
        'birth_year_unknown' => 'boolean',
    ];

    public function familyGroup()
    {
        return $this->belongsTo(FamilyGroup::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }

    public function getAgeAttribute()
    {
        return $this->birthday->age;
    }

    public function getDaysUntilBirthdayAttribute()
    {
        $next = $this->birthday->setYear(now()->year);
        if ($next->isPast()) {
            $next = $next->addYear();
        }
        return (int) now()->diffInDays($next);
    }

    public function getAgeOrGenerationAttribute(): string
    {
        if ($this->birth_year_unknown) {
            return '~' . ($this->generation ?? 'Unknown generation');
        }
        return 'Turning ' . ($this->birthday->age + 1);
    }
}
