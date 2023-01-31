<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'amount_entre',
        'amount_out'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function getEntrepriseOwner()
    {
        return $this->owner()->get();
    }

    public function membres()
    {
        return $this->belongsToMany(User::class, 'participants')->withTimestamps();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
