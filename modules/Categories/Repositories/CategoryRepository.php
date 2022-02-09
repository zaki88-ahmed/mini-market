<?php

namespace modules\Categories\Repositories;

use App\Http\Traits\ApiDesignTrait;
use modules\Categories\Interfaces\CategoryInterface;
use modules\Categories\Models\Category;

class CategoryRepository implements CategoryInterface
{

    use ApiDesignTrait;
    protected $category;

    public function __construct(Category $category)
    { 
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->all();
        return $this->ApiResponse(200,"All Category Are Returned Successfully",null,$categories);    
    }
 
    public function create($request)
    {
        $this->category->create($request->all());
        return $this->ApiResponse(200,"Category Added Successfully");
    }

    public function update($request,$cat_id)
    {  
        $category_id =$this->category::find($cat_id);
        if(!$category_id){
            return $this->ApiResponse(404,"Category Id Not Exist");     
        }
        $category_id->update($request->all());
        return $this->ApiResponse(200,"Category Updated Successfully");   
    }
   
    public function delete($cat_id)
    { 
        $category_id =$this->category::find($cat_id);
        if(!$category_id){
            return $this->ApiResponse(404,"Category Id Not Exist");     
        }
        $category_id->delete();
        return $this->ApiResponse(200,"Category Deleted Successfully");     
    }
    
    public function restore($cat_id)
    { 
        $category_id =$this->category::withTrashed()->find($cat_id);
        if(is_null($category_id->deleted_at)){
            return $this->ApiResponse(404,"Category Id Not Exist");     
        }
        $category_id->restore();
        return $this->ApiResponse(200,"Category Restored Successfully");     
    }

    public function restoreAll()
    {
        $this->category::onlyTrashed()->restore();  
        return $this->ApiResponse(200,"All Category Restored Successfully");     
    }
}
