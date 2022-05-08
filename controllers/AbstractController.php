<?php

abstract class AbstractController
{

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