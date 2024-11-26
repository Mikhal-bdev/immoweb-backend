<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'pays_id',
        'departement_id',
        'commune_id',
        'ville_id',
        'arrondissement_id',
        'quartier_id',
        'adresse',
        'numtel',
        'email',
        'password',
        'current_team_id',
        'profile_photo_path',
        'typeuser_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */

    public function pays()
    {
        return $this->belongsTo(Payss::class, 'pays_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }

    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class, 'arrondissement_id');
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class, 'quartier_id');
    }

    public function typeuser()
    {
        return $this->belongsTo(Typeuser::class, 'typeuser_id');
    }
}
