<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{

    use ResponseTrait;
    private object $model;
    public function __construct(){
        $this->model = Company::query();
    }
    public function index(Request $request):JsonResponse
    {
        $data = $this->model
            ->where('name','like','%'.$request->get('q').'%')
            ->get();
        return $this->successResponse($data);
    }
    public function check($companyName){
        $check = $this->model
            ->where('name', $companyName)
            ->exists();
        return $this->successResponse($check);
    }
}
