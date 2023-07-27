<?php

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface
{
    public function all();

    public function find($id, $columns = array('*'));

    public function create(array $input);

    public function destroy($id);

    public function update($id, array $input);
}

