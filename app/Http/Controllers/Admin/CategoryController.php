<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::latest()->paginate(10);
        return view("admin.categories")->with([
            "categories" => $categories
        ]);
    }
    public function create(Request $request){
        $this->validate($request,[
            "name"=>"required|string",
            "icon"=>"required|image",
        ]);
        $category = new Category;
        $category->name = $request->name;
        if($request->hasFile("icon")){
            $icon = $_FILES["icon"]["name"];
            $tmp = $_FILES["icon"]["tmp_name"];
            $path = "assets/categories/icon/";
            $icon = idate("U").$icon;
            if(\move_uploaded_file($tmp,$path.$icon)){
                $category->icon = $icon;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the icon");
                return redirect()->back();
            }
        }
        $category->save();
        $request->session()->flash('success', "Category successfully created");
        return redirect()->back();
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required",
        ]);
        $category = Category::find($request->id);
        if($category===NULL){
            $request->session()->flash('error', "The category does not exist");
            return redirect()->back();
        }
        else{
            unlink("assets/categories/icon/".$category->icon);
            $category->delete();
            $request->session()->flash('success', "Category successfully deleted");
            return redirect()->back();
        }
    }
}
