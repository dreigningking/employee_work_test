<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::whereNotNull('id');
        if(request()->query() && $name = request()->query('name')){
            $employees = $employees->where('name','LIKE',"%$name%");
        }
        if(request()->query() && $department = request()->query('department')){
            $employees = $employees->where('department','LIKE',"%$department%");
        }
        if(request()->query() && $sort = request()->query('sort')){
            switch($sort){
                case 'name_asc': $employees = $employees->orderBy('name','asc');
                    break;
                case 'name_desc': $employees = $employees->orderBy('name','desc');
                    break;
                case 'department_asc': $employees = $employees->orderBy('department','asc');
                    break;
                case 'department_desc': $employees = $employees->orderBy('department','desc');
                    break;
                case 'salary_asc': $employees = $employees->orderBy('salary','asc');
                    break;
                case 'salary_desc': $employees = $employees->orderBy('salary','desc');
                    break;
                
            }
        }
        if(!$employees->exists() && request()->expectsJson()){
            return response()->json(['status' => true,'message'=> 'Requested Data does not exist'],200);
        }
        $employees = $employees->paginate(5);
        
        return request()->expectsJson()
        ? response()->json(['status' => true,
        'data' => EmployeeResource::collection($employees),
        'meta'=> [
                    "total"=> $employees->total(),
                    "per_page"=> $employees->perPage(),
                    "current_page"=> $employees->currentPage(),
                    "last_page"=> $employees->lastPage(),
                    "first_page_url"=> $employees->url(1),
                    "last_page_url"=> $employees->url($employees->lastPage()),
                    "next_page_url"=> $employees->nextPageUrl(),
                    "prev_page_url"=> $employees->previousPageUrl(),
                ] 
            ], 200)
        : view('home',compact('employees'));
    }

    public function show(Employee $employee){
        if(!$employee && request()->expectsJson()){
            return response()->json(['status' => true,'message'=> 'Requested Data does not exist'],200);
        }
        return request()->expectsJson()
        ? response()->json(['status' => true,'data' => new EmployeeResource($employee)])
        : view('show',compact('employee'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:employees',
            'position' => 'required|string',
            'department' => 'required|string',
            'salary' => 'required|numeric|gt:0',
        ]);
        Employee::create(['name'=> $request->name, 'email'=> $request->email, 
        'position'=> $request->position, 'department'=> $request->department, 
        'salary'=> $request->salary]);
        return request()->expectsJson()
        ? response()->json(['status' => true,'message'=> 'Employee Created'], 200)
        : redirect()->route('home');
    }

    public function edit(Employee $employee){
        // dd($employee);
        return view('edit',compact('employee'));
    }

    public function update(Request $request){
        $employee = Employee::find($request->employee_id);
        $request->validate([
            'name' => 'required|string',
            'email' => ['required','email:rfc,dns',Rule::unique('employees')->ignore($employee)],
            'position' => 'required|string',
            'department' => 'required|string',
            'salary' => 'required|numeric|gt:0',
        ]);
        Employee::where('id',$request->employee_id)->update(['name'=> $request->name, 'email'=> $request->email, 
        'position'=> $request->position, 'department'=> $request->department, 
        'salary'=> $request->salary]);

        return redirect()->route('home');
        
    }

    public function api_update(Employee $employee,Request $request){
        Employee::where('id',$employee->id)->update(['name'=> $request->name, 'email'=> $request->email, 
        'position'=> $request->position, 'department'=> $request->department, 
        'salary'=> $request->salary]);
        return response()->json(['status' => true,'message'=> 'Employee Updated'], 200);
    }

    public function destroy(Request $request){
        Employee::destroy($request->employee_id);
        return redirect()->route('home');
        return response()->json(['status' => true,'message'=> 'Employee Deleted'], 200);
    }

    public function api_delete(Employee $employee){
        Employee::destroy($employee->id);
        return response()->json(['status' => true,'message'=> 'Employee Deleted'], 200);
    }

    public function api_login(Request $request){
        try {
            $validate = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors()->first()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            
            // $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
