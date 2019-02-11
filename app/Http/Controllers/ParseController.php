<?php

namespace App\Http\Controllers;

use App\ParseLink;
use App\UniqText;
use Illuminate\Http\Request;
use DB;
use App\Settings;

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

    public function createSitemap(){
        Settings::createSitemap();
    }

    public static function testSql(){
        UniqText::save_uniq_text('asd', 'asasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdd', 'asd','sdfsdfs', '123');
    }
}
