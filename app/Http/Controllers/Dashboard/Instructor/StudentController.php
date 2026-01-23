<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentInstructoreRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public $authId;
    public $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->authId = Auth::guard('instructor')->user()->id;
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $students  = Student::where('instructor_id', '=', $this->authId)->get();
        return view('backend.instructor.student.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('instructor_id', '=', $this->authId)->get();
        return view('backend.instructor.student.create')->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentInstructoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $student = $this->studentService->storeStudent($request->validated());
            DB::commit();
            return redirect()->route('instructor.student.index')->with('success', 'Student created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $courses = Course::where('instructor_id', $this->authId)->get();
        $student = Student::with('courses')->findOrFail($id);

        // IDs الكورسات المرتبطة بالطالب
        $studentCourseIds = $student->courses->pluck('id')->toArray();

        return view(
            'backend.instructor.student.edit',
            compact('courses', 'student', 'studentCourseIds')
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, StudentInstructoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $student = $this->studentService->updateStudent($request, $id);
            DB::commit();
            return redirect()->route('instructor.student.index')->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            $this->studentService->deleteStudent($student);
            DB::commit();
            return redirect()->route('instructor.student.index')->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            // جلب الطالب
            $student = Student::findOrFail($request->student_id);
            $student->status = $request->status;
            $student->save();

            // تحديث الـ User المرتبط
            if ($student->user_id) {
                $user = User::find($student->user_id);
                if ($user) {
                    $user->status = $request->status;
                    $user->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Student status updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Student not found!' . $e->getMessage()]);
        }
    }

    public function getStudentCourses($id)
    {
        $student = Student::with('courses')->findOrFail($id);

        $courses = $student->courses->map(function ($course) {
            return [
                'course_name' => $course->course_name,
                'image' => $course->course_image ? asset('uploads/' . $course->course_image) : null, // Assuming there's an image field
            ];
        });

        return response()->json([
            'success' => true,
            'student_name' => $student->name,
            'courses' => $courses
        ]);
    }
}
