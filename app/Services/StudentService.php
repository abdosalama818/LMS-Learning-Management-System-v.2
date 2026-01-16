<?php

namespace App\Services;

use App\Repository\StudentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class StudentService
{
    public $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }


 



    public function storeStudent($data)
    {


        $startDate = Carbon::now();
        $data['start_date'] = $startDate;
        $data['end_date'] =  $startDate->copy()->endOfMonth();
        $data['instructor_id'] = Auth::guard('instructor')->user()->id;

        $user = $this->studentRepository->createAuth($data);
        $data['user_id'] = $user->id;


        $student = $this->studentRepository->storeStudent($data);
        return $student;
    }

 


    public function updateStudent($request, $id)
    {

        $data = $request->validated();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user = $this->studentRepository->updateAuth($data, $id);

       return $this->studentRepository->updateStudent($data, $id);


    }


 
  
    public function deleteStudent($student){
      
       $this->studentRepository->deleteAuth($student);
        $this->studentRepository->deleteStudent($student);

    }
 


}
