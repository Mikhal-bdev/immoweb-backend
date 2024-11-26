<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrondissement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'arrondissements';

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
    protected $fillable = ['nom_arrond', 'ville_id'];

    /**
     * Get the ville that owns the arrondissement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
}