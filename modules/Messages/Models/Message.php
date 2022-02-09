<?php

namespace modules\Messages\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use modules\Products\Models\Product;


class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'title', 'body'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];




}


