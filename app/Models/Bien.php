<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'biens';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typebien_id',
        'user_id',
        'designation',
        'nbrchambr',
        'long',
        'larg',
        'etat',
        'localisation',
        'map',
        'desc',
        'conditions',
        'loyer',
        'avance',
        'caution',
        'compteau',
        'comptelec',
        'locatorsell',
        'photo1',
        'photo2',
        'photo3',
        'photo4',
        'photo5',
        'photo6',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'loyer' => 'float',
        'avance' => 'float',
        'caution' => 'float',
        'nbrchambr' => 'integer',
        'long' => 'float',
        'larg' => 'float',
    ];

    /**
     * Relations with TypeBien model.
     */
    public function typebien()
    {
        return $this->belongsTo(TypeBien::class, 'typebien_id');
    }

    /**
     * Relations with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    /**
     * Accessor for full photo URLs.
     */
    public function getPhoto1UrlAttribute()
    {
        return $this->photo1 ? asset('storage/' . $this->photo1) : null;
    }

    public function getPhoto2UrlAttribute()
    {
        return $this->photo2 ? asset('storage/' . $this->photo2) : null;
    }

    public function getPhoto3UrlAttribute()
    {
        return $this->photo3 ? asset('storage/' . $this->photo3) : null;
    }

    public function getPhoto4UrlAttribute()
    {
        return $this->photo4 ? asset('storage/' . $this->photo4) : null;
    }

    public function getPhoto5UrlAttribute()
    {
        return $this->photo5 ? asset('storage/' . $this->photo5) : null;
    }

    public function getPhoto6UrlAttribute()
    {
        return $this->photo6 ? asset('storage/' . $this->photo6) : null;
    }
}
