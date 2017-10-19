<?php

namespace App\Http\Controllers\Backend\Access\Permission;

use App\Models\Access\Permission\Permission;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Access\Permission\PermissionRepository;
use App\Http\Requests\Backend\Access\Permission\StorePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\ManagePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\UpdatePermissionRequest;

/**
 * Class RoleController.
 */
class PermissionController extends Controller
{
    /**
     * @var RoleRepository
     */
    // protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * @param RoleRepository       $roles
     * @param PermissionRepository $permissions
     */
    public function __construct(PermissionRepository $permissions)
    {
        // $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ManagePermissionRequest $request)
    {
        return view('backend.access.permissions.index');
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function create(ManagePermissionRequest $request)
    {
        return view('backend.access.permissions.create')
            ->with('permissions',$this->permissions->getAll());
    }

    /**
     * @param StoreRoleRequest $request
     *
     * @return mixed
     */
    public function store(StorePermissionRequest $request)
    {
        $this->permissions->create($request->only('name', 'display_name'));

        return redirect()->route('admin.access.permission.index')->with('flash_success',trans('alerts.backend.permissions.created'));
    }

    /**
     * @param Permission              $permission
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function edit(Permission $permission, ManagePermissionRequest $request)
    {
        return view('backend.access.permissions.edit')
            ->withPermission($permission)
            ->with('role_permissions',$permission->pluck('id')->all())
            ->withPermissions($this->permissions->getAll());
    }

    /**
     * @param Permission              $permission
     * @param UpdateRoleRequest $request
     *
     * @return mixed
     */
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $this->permissions->update($permission, $request->only('name', 'display_name'));

    
        return redirect()->route('admin.access.permission.index')->with('flash_success',trans('alerts.backend.permissions.updated'));
    }

    /**
     * @param Permission              $permission
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function destroy(Permission $permission, ManagePermissionRequest $request)
    {
        $this->permissions->delete($permission);

        return redirect()->route('admin.access.permission.index')->with('flash_success',trans('alerts.backend.roles.deleted'));
    }
}
