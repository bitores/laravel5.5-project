<?php

namespace App\Events\Backend\Access\Permission;

use Illuminate\Queue\SerializesModels;

/**
 * Class RoleDeleted.
 */
class PermissionDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $permission;

    /**
     * @param $role
     */
    public function __construct($permission)
    {
        $this->permission = $permission;
    }
}
