<?php

namespace App\Repository;

use App\Models\Student;
use App\Models\User;



class StudentRepository
{



    public function createAuth($data)
    {

        $user =  User::create([
            'name'     => $data['name'],
            'email'    => $data['student_email'],
            'password' => bcrypt($data['password']), // أو password خاص
            'status'   => $data['status'],
        ]);
        return $user;
    }



    public function storeStudent($data)
    {
      // احذف course_id من البيانات لإنشاء الطالب
    $studentData = $data;
    unset($studentData['course_id']);

    $student = Student::create($studentData);

    // ربط الكورسات (Many-to-Many)
    if (isset($data['course_id']) && is_array($data['course_id'])) {
        $student->courses()->attach($data['course_id']);
    }
        return $student;
    }


    public function updateAuth($data, $id)
    {
        $student = Student::findOrFail($id);
        $user = User::find($student->user_id);

        if (!$user) {
            return null; // أو throw Exception لو تحب
        }

        $updateData = [
            'name'   => $data['name'],
            'email'  => $data['student_email'],
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        $user->update($updateData);

        return $user;
    }



    public function updateStudent($data, $id)
    {
         $student = Student::findOrFail($id);

    // نفصل بيانات الطالب عن الكورسات
    $studentData = $data;
    unset($studentData['course_id']);

    // تحديث بيانات الطالب
    $student->update($studentData);

    // تحديث الكورسات (استبدال القديم بالجديد)
    if (isset($data['course_id']) && is_array($data['course_id'])) {
        $student->courses()->sync($data['course_id']);
    }
        return $student;
    }


    public function deleteStudent($student)
    {
        $student->delete();
    }

    public function deleteAuth($student)
    {
        $user = User::find($student->user_id);
        if ($user) {
            $user->delete();
        }
    }
}
