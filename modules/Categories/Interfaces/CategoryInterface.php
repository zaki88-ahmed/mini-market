<?php
namespace modules\Categories\Interfaces;

interface CategoryInterface {

    public function index();
    public function create($request);
    public function update($request,$cat_id);
    public function delete($cat_id);
    public function restore($cat_id);
    public function restoreAll();
}
