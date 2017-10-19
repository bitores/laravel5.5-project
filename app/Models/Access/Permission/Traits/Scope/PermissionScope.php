<?php

namespace App\Models\Access\Permission\Traits\Scope;

/**
 * Class RoleScope.
 */
trait PermissionScope
{
    /**
     * @param $query
     * @param string $direction
     *
     * @return mixed
     */
    public function scopeSort($query, $direction = 'asc')
    {
        return $query->orderBy('sort', $direction);
    }
}
