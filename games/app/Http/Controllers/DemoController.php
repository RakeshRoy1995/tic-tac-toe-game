<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\WiningCombinationTrait;

class DemoController extends Controller
{
    use WiningCombinationTrait;

    public function index()
    {
        $type = count($_GET) ? $_GET['boradType'] : 3;
        $page = view('gamePage', ['type' => $type]);
        $combination = $this->BoardType($type);
        return view('welcome' , ['page'=> $page , 'type'=>$type, 'combination' => $combination ]);
    }
}
