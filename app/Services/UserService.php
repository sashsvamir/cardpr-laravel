<?php
namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public static function create(string $phone, string $email, string $password)
    {
        return User::create([
            'phone' => $phone,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    public static function update(User $user, array $validated) : bool
    {
        return $user->update([
            'email' => $validated['email'],
        ]);
    }

    public static function updatePassword(User $user, string $password) : bool
    {
        return $user->forceFill([
            'password' => Hash::make($password),
        ])->save();
    }

    public static function delete(User $user) : ?bool
    {
        return $user->delete();
    }
}
