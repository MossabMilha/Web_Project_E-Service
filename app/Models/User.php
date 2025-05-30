<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable{
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
    public static function updateField($id, $field, $value)
    {
        $user = self::findOrFail($id);
        $user->$field = $value;
        $user->save();
        return $user;
    }
    public static function EmailIsUsed($email,$id = 0)
    {
        return self::where('email', $email)->where('id', '!=', $id)->exists();
    }
    public static function PhoneIsUsed($phone,$id =0){
        return self::where('phone', $phone)->where('id', '!=', $id)->exists();
    }
    public static function validName($name)
    {
        if (preg_match('/^[a-zA-Z\s\-]+$/', $name)) {
            return true;  // Valid name
        }
        return 'Name must contain only letters, spaces, and hyphens.';
    }
    public static function validEmail($email, $id = 0)
    {
        $messages = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messages['email.valid'] = 'Email is invalid';
        }


        if (preg_match('/^\d+@/', $email)) {
            $messages['email.invalidFormat'] = 'Email cannot start with numbers before the "@" symbol';
        }


        if (self::EmailIsUsed($email, $id)) {
            $messages['email.unique'] = 'Email is already used';
        }

        return empty($messages) ? true : $messages;
    }


    public static function validPhoneNumber($phone, $id = 0)
    {
        $messages = [];

        if (!preg_match('/^\+\d{1,3}[-\s]?\d{7,12}$/', $phone)) {
            $messages['phone.valid'] = 'Invalid phone number format. (+xxx xxxxxxxxx)';
        }


        if (self::PhoneIsUsed($phone, $id)) {
            $messages['phone.unique'] = 'Phone number is already used.';
        }

        return empty($messages) ? true : $messages;
    }
    public static function validPassword($password,$id)
    {
        $messages = [];
        $user = self::where('id', $id)->first();


        $name = preg_replace('/\s+/', '', $user->name);


        $nameParts = [];
        $nameLength = strlen($name);
        for ($i = 0; $i <= $nameLength - 8; $i++) {
            $nameParts[] = substr($name, $i, 8);
        }


        foreach ($nameParts as $part) {
            if (stripos($password, $part) !== false) {
                $messages['password.name'] = 'Password Should not contain your name Or part of it';
            }
        }

        // Validate password complexity
        if (
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[\W_]/', $password)
        ) {
            $messages['password.valid'] = 'Password must contain at least one uppercase, one lowercase, one number, and one special character.';
        }

        return empty($messages) ? true : $messages;
    }




    public static function checkEmailPassword($email, $password): ?User
    {
        $user = self::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user; // Return the User object instead of true
        }

        return null; // Return null instead of false
    }

    public static function generateSecurePassword(): string
    {
        $length = rand(8, 12); // Random length between 8 and 12

        $upper = chr(rand(65, 90)); // A-Z
        $lower = chr(rand(97, 122)); // a-z
        $number = chr(rand(48, 57)); // 0-9
        $special = chr(rand(33, 47)); // Special characters like ! " # etc.

        // Fill the rest of the password with random characters from all types
        $all = array_merge(
            range('a', 'z'),
            range('A', 'Z'),
            range('0', '9'),
            str_split('!@#$%^&*()_+=-{}[]|:;<>,.?')
        );

        $remainingLength = $length - 4;
        $rest = [];

        for ($i = 0; $i < $remainingLength; $i++) {
            $rest[] = $all[array_rand($all)];
        }

        // Combine all characters and shuffle
        $passwordArray = array_merge([$upper, $lower, $number, $special], $rest);
        shuffle($passwordArray);

        return implode('', $passwordArray);
    }

    public static function unassignedVacataires()
    {
        return self::where('role', 'vacataire')
            ->whereDoesntHave('assignments')
            ->get();
    }

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class, 'user_filiere', 'user_id', 'filiere_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'professor_id');
    }

    public function departmentMember()
    {
        return $this->hasOne(DepartmentMember::class, 'professor_id');
    }


    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization', 'id');
    }

}
