<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogActivity
 *
 * @property $id
 * @property $user_id
 * @property $action
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LogActivity extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'action', 'description'];

    // Fonction pour enregistrer un log
    public static function addToLog($action, $description)
    {
        $log = new self();
        $log->user_id = Auth::id(); // Utilisateur connecté
        $log->action = $action;
        $log->description = $description;
        $log->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
