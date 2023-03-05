<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserWeatherData extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'weather', 'description'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
