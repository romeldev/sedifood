<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Setting\Models\Menu;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    public $table = 'usuarios';

    public $timestamps = false;

    protected $primaryKey = 'id_usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'nro_documento', 'datos', 'email', 'celular', 'id_almacen', 'estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIdAttribute() 
    {
        return $this->attributes['id_usuarios'];
    }

    public function setIdAttribute($value) 
    {
        return $this->attributes['id_usuarios'] = $value;
    }

    public function getWarehouseIdAttribute() 
    {
        return $this->attributes['id_almacen'];
    }

    public function setWarehouseIdAttribute($value) 
    {
        return $this->attributes['id_almacen'] = $value;
    }

    public function getMenuAttribute()
    {
        return Menu::data();
    }

    public function getAvatarAttribute()
    {
        return '/img/avatar.svg';
    }
}
