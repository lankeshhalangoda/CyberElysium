<?php

namespace domain\Services;

use App\Models\Student;

class StudentService
{
    protected $student;

    //construct
    public function __construct()
    {
        $this->student = new Student();
    }

    //get student list
    public function all()
    {
        return  $this->student->all();
    }

    //get student details
    public function get($student_id)
    {
        return  $this->student->find($student_id);
    }

    //store student
    public function store($data)
    {
        $this->student->create($data);
    }

    //student edit
    public function edit(Student $student, $data)
    {
        return  array_merge($student->toArray(), $data);
    }

    //student delete
    public function delete($student_id)
    {
        $student =  $this->student->find($student_id);
        $student->delete();
    }

    //student update
    public function update(array $data, $student_id)
    {
        $student =  $this->student->find($student_id);
        $student->update($this->edit($student, $data));
    }

    //change student status
    public function status($student_id)
    {
        $student = $this->student->find($student_id);
        if ($student->status == 1) {
            $student->status = 0;
        } else {
            $student->status = 1;
        }
        $student->update();
    }
}
