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
    protected $fillable = ['nom_ville', 'commune_id'];

    /**
     * Scope for searching.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            $query->where('nom_ville', 'LIKE', "%{$searchTerm}%");
        }
        return $query;
    }

    /**
     * Scope for sorting.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sortBy
     * @param string $sortOrder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, $sortBy, $sortOrder)
    {
        $allowedSorts = ['nom_ville', 'commune_id', 'created_at', 'updated_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = ($sortOrder === 'asc' || $sortOrder === 'desc') ? $sortOrder : 'desc';

        return $query->orderBy($sortBy, $sortOrder);
    }
}
