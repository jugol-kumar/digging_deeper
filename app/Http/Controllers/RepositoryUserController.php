<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class RepositoryUserController extends Controller
{
    public $user;

    public function __construct(Repository $user)
    {
        $this->user = $user;
    }

    public function index(){
        return $this->user->getAllUser();
    }

    public function updateOrCreate(Request $request, $id){
        if (is_null($id)){
            return $this->user->creatOrUpdate($request->except(['_token','_method']));
        }else{
            return $this->user->creatOrUpdate($id, $request->except(['_token','_method']));
        }
    }

    public function showUser($id){
        return $this->user->getUserById($id);
    }
    public function delete($id){
        return $this->user->deleteUser($id);
    }
}
