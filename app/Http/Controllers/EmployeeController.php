<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function viewEmployee(){
        $employees=Employee::get();
        return view('employee.viewall',compact('employees'));
    }
    public function showEmployee($id){
        $employee=Employee::find($id);
        return view('employee.viewEmployee',compact('employee'));
    }

    public function createEmployee(){
        return view('employee.add');
    }

    public function storeEmployee(Request $request)
{
   $employee=new Employee();
   $employee->name=$request->name;
   $employee->designation=$request->designation;
   $employee->email=$request->email;
   $employee->phone=$request->phone;
   $employee->address=$request->address;
   $employee->date_of_birth=$request->dob;
   $employee->gender=$request->gender;
   $employee->religion=$request->religion;
   $employee->joining_date=$request->joining_date;
   $image=$request->file('image');
   $imagePath=$image->store('images','public');
   $employee->image=$imagePath;
    $employee->save();
   return redirect()->back()->with('message','Employee added successfully');
}
public function deleteEmployee($id){
    $employee=Employee::find($id);
    $employee->delete();
    return redirect()->back()->with('message','Employee deleted successfully');
}
public function editEmployee($id){
    $employee=Employee::find($id);
    return view('Employee.edit',compact('employee'));
}

public function updateEmployee(Request $request,$id){
    $employee=Employee::find($id);
    $employee->name=$request->name;
    $employee->designation=$request->designation;
    $employee->email=$request->email;
    $employee->phone=$request->phone;
    $employee->address=$request->address;
    $employee->date_of_birth=$request->dob;
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
