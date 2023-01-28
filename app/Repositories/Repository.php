<?php


namespace App\Repositories;


interface Repository
{
    public function getAllUser();
    public function getUserById($id);
    public function creatOrUpdate($id = null, $collection=[]);
    public function deleteUser($id);

}
