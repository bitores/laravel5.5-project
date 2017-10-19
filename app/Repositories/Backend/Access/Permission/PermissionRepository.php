<?php

namespace App\Repositories\Backend\Access\Permission;

use App\Models\Access\Permission\Permission;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Access\Permission\PermissionCreated;
use App\Events\Backend\Access\Permission\PermissionDeleted;
use App\Events\Backend\Access\Permission\PermissionUpdated;

/**
 * Class RoleRepository.
 */
class PermissionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Permission::class;


    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            // ->with('permissions')
            ->select([
                config('access.permissions_table').'.id',
                config('access.permissions_table').'.name',
                config('access.permissions_table').'.display_name'
            ]);
    }

    /**
     * @param array $input
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        if ($this->query()->where('name', $input['name'])->first()) {
            throw new GeneralException(trans('exceptions.backend.access.permissions.already_exists'));
        }

        //See if the role has all access
        // $all = $input['associated-permissions'] == 'all' ? true : false;

        // if (! isset($input['permissions'])) {
        //     $input['permissions'] = [];
        // }

        // //This config is only required if all is false
        // if (! $all) {
        //     //See if the role must contain a permission as per config
        //     if (config('access.roles.role_must_contain_permission') && count($input['permissions']) == 0) {
        //         throw new GeneralException(trans('exceptions.backend.access.roles.needs_permission'));
        //     }
        // }

        DB::transaction(function () use ($input) {
            $permission = self::MODEL;
            $permission = new $permission();
            $permission->name = $input['name'];
            $permission->display_name = $input['display_name'];
            // $permission->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int) $input['sort'] : 0;

            // //See if this role has all permissions and set the flag on the role
            // $role->all = $all;

            if ($permission->save()) {
                // if (! $all) {
                //     $permissions = [];

                //     if (is_array($input['permissions']) && count($input['permissions'])) {
                //         foreach ($input['permissions'] as $perm) {
                //             if (is_numeric($perm)) {
                //                 array_push($permissions, $perm);
                //             }
                //         }
                //     }

                //     $role->attachPermissions($permissions);
                // }

                event(new PermissionCreated($permission));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.permissions.create_error'));
        });
    }

    /**
     * @param Model $role
     * @param  $input
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function update(Model $permission, array $input)
    {
        //See if the role has all access, administrator always has all access
        // if ($permission->id == 1) {
        //     $all = true;
        // } else {
        //     $all = $input['associated-permissions'] == 'all' ? true : false;
        // }

        if (! isset($input['permissions'])) {
            $input['permissions'] = [];
        }

        //This config is only required if all is false
        // if (! $all) {
        //     //See if the role must contain a permission as per config
        //     if (config('access.roles.role_must_contain_permission') && count($input['permissions']) == 0) {
        //         throw new GeneralException(trans('exceptions.backend.access.roles.needs_permission'));
        //     }
        // }

        $permission->name = $input['name'];
        $permission->display_name = $input['display_name'];
        // $permission->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int) $input['sort'] : 0;

        //See if this role has all permissions and set the flag on the role
        // $role->all = $all;

        DB::transaction(function () use ($permission, $input) {
            if ($permission->save()) {
                //If role has all access detach all permissions because they're not needed
                // if ($all) {
                //     $role->permissions()->sync([]);
                // } else {
                //     //Remove all roles first
                //     $permission->permissions()->sync([]);

                //     //Attach permissions if the role does not have all access
                //     $permissions = [];

                //     if (is_array($input['permissions']) && count($input['permissions'])) {
                //         foreach ($input['permissions'] as $perm) {
                //             if (is_numeric($perm)) {
                //                 array_push($permissions, $perm);
                //             }
                //         }
                //     }

                //     $role->attachPermissions($permissions);
                // }

                event(new PermissionUpdated($permission));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.permissions.update_error'));
        });
    }

    /**
     * @param Model $role
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Model $permission)
    {
        //Would be stupid to delete the administrator permission
        if ($permission->id == 1) { //id is 1 because of the seeder
            throw new GeneralException(trans('exceptions.backend.access.permissions.cant_delete_admin'));
        }

        //Don't delete the permission is there are users associated
        // if ($permission->users()->count() > 0) {
        //     throw new GeneralException(trans('exceptions.backend.access.permissions.has_users'));
        // }

        DB::transaction(function () use ($permission) {
            //Detach all associated permissions
            // $permission->permissions()->sync([]);

            if ($permission->delete()) {
                event(new PermissionDeleted($permission));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.permissions.delete_error'));
        });
    }

    /**
     * @return mixed
     */
    // public function getDefaultUserRole()
    // {
    //     if (is_numeric(config('access.users.default_role'))) {
    //         return $this->query()->where('id', (int) config('access.users.default_role'))->first();
    //     }

    //     return $this->query()->where('name', config('access.users.default_role'))->first();
    // }
}
