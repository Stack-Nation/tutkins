<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestGroup;

class TestsController extends Controller
{
    public function index(){
        $tests = Test::latest()->paginate(10);
        return view("admin.tests.test.index")->with([
            "tests"=>$tests,
            "type"=>"tests",
        ]);
    }
    public function groups(){
        $groups = TestGroup::latest()->paginate(10);
        return view("admin.tests.group.index")->with([
            "groups"=>$groups,
            "type"=>"groups",
        ]);
    }
}
