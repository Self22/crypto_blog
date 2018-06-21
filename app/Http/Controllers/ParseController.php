<?php

namespace App\Http\Controllers;

use App\ParseLink;
use Illuminate\Http\Request;
use DB;

class ParseController extends Controller
{
    public function index(){
        ParseLink::parse_cryptonews();
    }
}
