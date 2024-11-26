<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'communes';

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
    protected $fillable = ['nom_commune', 'departement_id'];

    /**
     * Relation avec le modèle `Departement`.
     * Une commune appartient à un département.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    /**
     * Relation avec le modèle `Arrondissement`.
     * Une commune peut avoir plusieurs arrondissements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arrondissements(): HasMany
    {
        return $this->hasMany(Arrondissement::class, 'commune_id');
    }
}
