<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPengguna;

class User extends BaseController
{
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->dataPengguna = new ModelPengguna();
    }

    public function index()
    {
        $data['user'] = $this->dataPengguna->where('email', session()->get('email'))->first();
        return view('user/pages/dashboard', $data);
    }
}
