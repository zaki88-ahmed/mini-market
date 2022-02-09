<?php

namespace modules\Customers\Models;

use App\Events\RegisterEventMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use modules\Products\Models\Product;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class Customer extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $dispatchesEvents = [ 'created' => RegisterEventMail::class];

    protected $fillable = ['name', 'email', 'password'];
    protected $guard_name = 'customer';
    protected $hidden = ['id', 'password', 'email_verified_at', 'remember_token', 'deleted_at', 'created_at', 'updated_at', 'Oauth_token', 'fcm_token'];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }


}
