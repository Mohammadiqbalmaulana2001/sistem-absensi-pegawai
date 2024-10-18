<?php

namespace App\Repositories;

use App\Interfaces\PegawaiInterface;
use App\Models\Pegawai;

class PegawaiRepositories implements PegawaiInterface
{
    public function index(){
        return Pegawai::with('Absens')->get();
    }

    public function getById($id){
        return Pegawai::with('absens')->find($id);
    }

    public function store(array $data){
        return Pegawai::create($data);
    }

    public function update(array $data,$id){
        return Pegawai::whereId($id)->update($data);
    }
    
    public function delete($id){
        Pegawai::destroy($id);
    }
}
