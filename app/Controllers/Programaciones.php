<?php

namespace App\Controllers;


use App\Models\ProgramacionM;

class Programaciones extends BaseController
{
    public function programacion(): string
    {
        return view('programa/Programacion');
    }

}
