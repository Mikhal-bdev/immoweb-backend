<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'privileges';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idtypeuser', 'typepriv', 'designpriv'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'idtypeuser' => 'integer',
    ];

    /**
     * Define the relationship with the TypeUser model.
     * 
     * Assuming `idtypeuser` references the `id` column in the `type_users` table.
     */
    public function typeUser()
    {
        return $this->belongsTo(TypeUser::class, 'idtypeuser', 'id');
    }
}
