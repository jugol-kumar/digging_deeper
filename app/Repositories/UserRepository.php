<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements Repository
{

    public function getAllUser()
    {
        // TODO: Implement getAllUser() method.
        return User::all();
    }

    public function getUserById($id)
    {
        // TODO: Implement getUserById() method.
        return User::find($id);
    }

    public function creatOrUpdate($id = null, $collection = [])
    {
        // TODO: Implement creatOrUpdate() method.

        if (is_null($id)){
            $user = new User();
            $user->name = $collection['name'];
            $user->email = $collection['email'];
            $user->password = Hash::make($collection['password']);
            return $user->save();
        }
        $user = $this->getUserById($id);
        $user->name = $collection['name'];
        $user->email = $collection['email'];
        $user->password = Hash::make($collection['password']);
        return $user->save();
    }

    public function deleteUser($id)
    {
        // TODO: Implement deleteUser() method.
        return $this->getUserById($id)->delete();
    }
}
