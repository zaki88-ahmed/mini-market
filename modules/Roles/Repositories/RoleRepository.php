<?php

namespace modules\Roles\Repositories;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use modules\Roles\Interfaces\RoleInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleInterface
{

    use ApiDesignTrait;


    protected $role;

    public function __construct(Role $role)
    { 
        $this->role = $role;
    }

    public function index()
    {
        $roles = $this->role->all();
        return $this->ApiResponse(200,"All Roles Are Returned Successfully",null,$roles);
        
    }
 
    public function create($request)
    {
        $this->role->create($request->all());
        return $this->ApiResponse(200,"Role Added Successfully");
    }

    public function update($request,$role_id)
    {
         $this->role = Role::find($role_id);
         $this->role->update($request->all());
        return $this->ApiResponse(200,"Role Updated Successfully");
        
    }
   
    public function delete($role_id)
    {
        $this->role = Role::find($role_id);
         $this->role->delete($role_id);
         return $this->ApiResponse(200,"Role Deleted Successfully");
        
    }

    public function assignPermission($request, $role_id)
    {
        $this->role= Role::find($role_id);

        $this->role->syncPermissions($request->permissions);

        return response()->json(['message' => 'Permissions assigned to the role', 'data' => $this->role->permissions()->get()], 200);
    }
}
