<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payss extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payss';

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
    protected $fillable = ['code', 'alpha2', 'alpha3', 'nom_en_gb', 'nom_fr_fr', 'created_at', 'updated_at'];
}
