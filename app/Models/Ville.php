<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'villes';

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
    protected $fillable = ['nom_ville', 'commune_id', 'created_at', 'updated_at'];

    
}
