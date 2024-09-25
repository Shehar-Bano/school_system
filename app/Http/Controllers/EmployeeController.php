<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEmployeeRequest;
use App\Http\Requests\storeEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    // designation
    public function designationView(){
        $designations=Designation::get();
        return view('employee.designation',compact('designations'));
    }
    public function designationStore(Request $request){
        $request->validate([
            'name'=>'required|string|max:225',
        
            ]);
            Designation::create([
                'name'=>$request->name,
               
                
                ]);
                return redirect()->back()->with('message','Designation Added Successfully');
    }
    public function designationDelete($id){
        $id=Designation::findOrFail($id);
        $id->delete();
        return redirect()->back()->with('success','Designation Deleted Successfully');
    }

    /////employee
    public function viewEmployee(){
        $employees=Employee::with('designation')->get();
        return view('employee.viewall',compact('employees'));
    }
    public function showEmployee($id){
        $employee=Employee::find($id);
        return view('employee.viewEmployee',compact('employee'));
    }

    public function createEmployee(){
        $designations=Designation::get();
        return view('employee.add',compact('designations'));
    }

    public function storeEmployee(storeEmployeeRequest $request)
{
   $employee=new Employee();
   $employee->name=$request->name;
   $employee->designation_id=$request->designation;
   $employee->email=$request->email;
   $employee->phone=$request->phone;
   $employee->address=$request->address;
   $employee->date_of_birth=$request->date_of_birth;
   $employee->gender=$request->gender;
   $employee->religion=$request->religion;
   $employee->joining_date=$request->joining_date;
   $employee->salary=$request->salary;
   $image=$request->file('image');
   $imagePath=$image->store('images','public');
   $employee->image=$imagePath;
   $employee->status='inactive';
    $employee->save();
   return redirect()->back()->with('message','Employee added successfully');
}
public function deleteEmployee($id){
    $employee=Employee::find($id);
    $employee->delete();
    return redirect()->back()->with('message','Employee deleted successfully');
}
public function editEmployee($id){
    $designations=Designation::get();
    $employee=Employee::with('designation')->find($id);
    return view('Employee.edit',compact('employee','designations'));
}

public function updateEmployee(UpdateEmployeeRequest $request,$id){
    $employee=Employee::find($id);
    $employee->name=$request->name;
    $employee->designation_id=$request->designation;
    $employee->email=$request->email;
    $employee->phone=$request->phone;
    $employee->address=$request->address;
    $employee->date_of_birth=$request->date_of_birth;
    $employee->gender=$request->gender;
    $employee->religion=$request->religion;
    $employee->joining_date=$request->joining_date;
    if($request->image){
        $image=$request->file('image');
        $imagePath=$image->store('images','public');
        $employee->image=$imagePath;
    }

     $employee->save();
    return redirect()->back()->with('message','Employee Updated successfully');

}

}
