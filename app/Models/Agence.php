<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agences';

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
        'user_id',
        'nom',
        'photagen',
        'regcomm',
        'docrccm',
        'ifu',
        'docifu',
        'numcni',
        'doccni',
        'cip',
        'doccip',
        'adresse',
        'mail',
        'contact',
        'whatsapp',
        'descrip',
        'certification',
    ];

    /**
     * Relations - Une agence appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
