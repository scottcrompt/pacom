<?php

abstract class AbstractController
{


    public function getUser() {
        if (!isset($_COOKIE['sessionToken'])) {
            var_dump('no cookie!');
            return false;
        }

        $userDAO = new UserDAO();
        return $userDAO->fetch($_COOKIE['sessionToken'],'sessionToken');
    }


    public function LoggedUserRole() {
        $user = $this->getUser();
        if(!$user) {
            include_once ('../views/head.php');
            include_once('../views/accueil/accueil.php');
            include_once ('../views/foot.php');
            return false;
        }
        return $user->role->nom;
    }

    public function create()
    {
        var_dump('no create');
    }

    public function edit($id)
    {
        var_dump('no edit');
    }

    public function delete($data)
    {
        var_dump('no delete');
    }

    public function update($id, $data)
    {
        var_dump('no update');
    }

    public function store($id, $data)
    {
        var_dump('no store');
    }

    public function show ($id,$data) {
        var_dump('no show');
    }

    public function index()
    {
        var_dump('no index');
    }


    public function deleteToken()
    {
        var_dump('no deleteToken');
    }

}