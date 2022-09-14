<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'   //laravel solo espera las entradas por defector aqui la apuntamos para que sepa que es segura
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //establecemos la relaacion eloquent con post model one to many revisar con tinker por defecto trae toda la tabla
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followers()
    {   //en la tabla de followers pertenece a muchos usuarios y especificamos las claves foraneas.. userid es el muro que estamos visitando followerid es quien da en seguir
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); //poner el fillble en el nodel de follower
    }

    //comprobar cuantos seguimos
    public function followings()
    {   
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id'); 
    } 

    //comprobar seguidores
    public function siguiendo(User $user)
    {
        return $this->followers->contains($user->id); //entra el metodo follower y busca el id en la tabla de followers
    }
}
