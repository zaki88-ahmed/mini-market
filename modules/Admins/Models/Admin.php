<?php

namespace modules\Admins\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use modules\Cities\Models\City;
use modules\Countries\Models\Country;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * @OA\Schema(
 *     required={"country_id","city_id","name","email","password","contact"},
 *     @OA\Xml(name="Admin"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="email", type="string", readOnly="true", format="email", description="Admin unique email address", example="Admin@gmail.com"),
 *     @OA\Property(property="name", type="string", readOnly="true", example="Admin"),
 *     @OA\Property(property="password", type="string", readOnly="true", format="password",example="password12345"),
 *     @OA\Property(property="contact", type="string", readOnly="true",description="Admin unique mobile number", example="01234567891"),
 *     @OA\Property(property="country_id", type="integer", readOnly="true", example="2"),
 *     @OA\Property(property="city_id", type="integer", readOnly="true", example="4"),
 * )
 */

class Admin extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $fillable = [ "name", "email", "password", "contact" ],
              $guard_name = 'admin',
              $hidden = ["created_at",'password', "updated_at", "deleted_at","id"];


}
