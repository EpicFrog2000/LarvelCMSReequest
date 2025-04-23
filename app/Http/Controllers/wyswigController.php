<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class wyswigController extends Controller
{
    public function getWyswigElement($dev_name)
    {
        return file_get_contents(public_path('partials/'.$dev_name.'.blade.html'));
    }
}
