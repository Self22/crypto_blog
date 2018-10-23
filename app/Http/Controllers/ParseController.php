<?php

namespace App\Http\Controllers;

use App\ParseLink;
use Illuminate\Http\Request;
use DB;

class ParseController extends Controller
{

    public function test2(){
        ParseLink::parse_cryptonews();
    }

    public function test3(){
        ParseLink::parse_coindesk();
    }

    public function clean_parse(){
        ParseLink::clean_parse_text();
    }
}
