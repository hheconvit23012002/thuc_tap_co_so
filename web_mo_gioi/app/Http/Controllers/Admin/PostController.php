<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostCurrnencySalary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
class PostController extends Controller
{
    use ResponseTrait;
    private object $model;
    private string $table;
    public function __construct(){
        $this->model = Post::query();
        $this->table =(new Post())->getTable();
        View::share('title',ucwords($this->table));
        View::share('table',$this->table);
    }
    public function index(){
        return view('admin.posts.index');
    }
    public function create(){
        $currencies = PostCurrnencySalary::asArray();
        return view('admin.posts.create',[
            'currencies' => $currencies
        ]);
    }
    public function importCsv(Request $request){
        try {
            Excel::import(new PostImport(), $request->file('file'));
            return $this->successResponse();
        }catch (\Exception $e){
            return $this->errorResponse();
        }
    }
    public  function store(StoreRequest $request){
        return $request->all();
    }
}
