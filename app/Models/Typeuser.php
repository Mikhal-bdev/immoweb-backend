<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Typeuser extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'typeusers';

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
    protected $fillable = ['type', 'designation'];

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
            $query->where('type', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('designation', 'LIKE', "%{$searchTerm}%");
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
        $allowedSorts = ['type', 'designation', 'created_at', 'updated_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = ($sortOrder === 'asc' || $sortOrder === 'desc') ? $sortOrder : 'desc';

        return $query->orderBy($sortBy, $sortOrder);
    }
}
