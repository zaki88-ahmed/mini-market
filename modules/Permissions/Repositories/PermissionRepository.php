<?php

namespace modules\Permissions\Repositories;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use modules\Permissions\Interfaces\PermissionInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{

    use ApiDesignTrait;



    protected $permission;

    public function __construct(Permission $permission)
    { 
        $this->permission = $permission;
    }

    public function index()
    {
        $permissions = $this->permission->all();
        return $this->ApiResponse(200,"All Permissions Are Returned Successfully",null,$permissions);  
    }
 
    public function create($request)
    {
        $this->permission->create($request->all());
        return $this->ApiResponse(200,"Permission Added Successfully");
    }

    public function update($request,$permission_id)
    {
         $this->permission = Permission::find($permission_id);
         $this->permission->update($request->all());
        return $this->ApiResponse(200,"Permission Updated Successfully");
        
    }
   
    public function delete($permission_id)
    {
        $this->permission = Permission::find($permission_id);
         $this->permission->delete($permission_id);
         return $this->ApiResponse(200,"Permission Deleted Successfully");
        
    }

}
