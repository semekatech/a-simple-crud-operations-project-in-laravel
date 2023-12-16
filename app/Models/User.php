<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeMembers($query)
    {
        return $query->where('user_type', 'member')->orderBy('created_at', 'desc');
    }


    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? (asset('storage/') . $value) : null,
        );
    }

    public function getIsAdminAttribute()
    {
        return $this->user_type == 'admin';
    }

    public function employment_histories()
    {
        return $this->hasMany(EmploymentHistory::class, 'user_id', 'id');
    }
    public function employment_history()
    {
        return $this->hasOne(EmploymentHistory::class, 'user_id', 'id');
    }
    public function getCommittee()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
