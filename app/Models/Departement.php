<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departements';

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
    protected $fillable = ['nom_dep', 'payss_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payss_id' => 'integer',
    ];

    /**
     * Get the country that owns the department.
     */
    public function pays()
    {
        return $this->belongsTo(Payss::class, 'payss_id');
    }
}
