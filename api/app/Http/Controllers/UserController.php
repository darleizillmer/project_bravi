<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use DB;
use Auth;
use Storage;

class UserController extends Controller
{
    private $user;
    
    public function __construct(User $user){
        $this->user = $user;
    }
    
}
