<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');

class TestController extends Controller
{
    //
}
