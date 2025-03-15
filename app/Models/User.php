<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;


class User extends Model{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'specialization'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    public static function addUser($name, $email, $password, $role, $specialization = null){
        return self::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'specialization' => $specialization,
        ]);
    }


    public static function checkEmailPassword($email, $password): ?User
    {
        $user = self::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user; // Return the User object instead of true
        }

        return null; // Return null instead of false
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'professor_id'); // foreign key
    }




}
