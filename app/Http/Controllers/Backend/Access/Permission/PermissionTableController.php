<?php

namespace App\Http\Controllers\Backend\Access\Permission;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Access\Permission\PermissionRepository;
use App\Http\Requests\Backend\Access\Permission\ManagePermissionRequest;

/**
 * Class RoleTableController.
 */
class PermissionTableController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $permissions;

    /**
     * @param RoleRepository $roles
     */
    public function __construct(PermissionRepository $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePermissionRequest $request)
    {


        // return $this->permissions->getForDataTable();

        return DataTables::of($this->permissions->getForDataTable())
            ->escapeColumns(['name'])
            // ->addColumn('permissions', function ($permission) {
            //     if ($permission->all) {
            //         return '<span class="label label-success">'.trans('labels.general.all').'</span>';
            //     }

            //     return $permission->count() ?
            //         implode('<br/>', $permission->permissions->pluck('display_name')->toArray()) :
            //         '<span class="label label-danger">'.trans('labels.general.none').'</span>';
            // })
            // ->addColumn('display_name', function ($permission) {
            //     return $permission->display_name;
            // })
            ->addColumn('actions', function ($permission) {
                return $permission->action_buttons;
            })
            ->make(true);
    }
}
