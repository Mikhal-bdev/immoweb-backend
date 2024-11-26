<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quartiers';

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
    protected $fillable = ['nom_qtier', 'arrondissement_id', 'created_at', 'updated_at'];

    /**
     * Relation avec l'arrondissement auquel appartient ce quartier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class);
    }

    /**
     * Exemple d'accesseur pour 'nom_qtier' : retourner le nom avec la première lettre en majuscule
     *
     * @param  string  $value
     * @return string
     */
    public function getNomQtierAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Exemple de cast pour les dates (facultatif).
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
