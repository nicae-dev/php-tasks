<?php
class Student {
    public string $name;
    public array $courses;
    public function __construct(string $name) {
        $this->name = $name;
    }
    public function addCourse(string $name, $grade) {
        $this->courses[$name] = $grade;
    }

}
class CourseManager {

    public array $students = [];
    public array $courses = [];

    public function __construct($studentsInfo, $coursesInfo) {
        $this->setStudents($studentsInfo);
        $this->setScores($coursesInfo);
    }

    public function setStudents($studentsInfo) {
        $studentsInfo = explode(';', $studentsInfo);
        foreach ($studentsInfo as $info) {
            $info = explode(',', $info);
            if (!isset($this->students[$info[0]])) {
                $this->students[$info[0]] = new Student($info[0]);
            }
            $this->students[$info[0]]->addCourse($info[1], $info[2]);
        }
    }

    public function setScores($coursesInfo) {
        $coursesInfo = explode(';', $coursesInfo);
        foreach ($coursesInfo as $info) {
            $info = explode(',', $info);
            $this->courses[$info[0]] = $info[1];
        }
    }

    public function coursesWithDuty(): array {
        $coursesWithoutDuty = $this->courses;
        foreach ($this->students as $student) {
            foreach ($student->courses as $st_course => $st_grade) {
                if ($coursesWithoutDuty[$st_course] && $st_grade < $this->courses[$st_course]) {
                    unset($coursesWithoutDuty[$st_course]);
                }
            }
        }
        return $coursesWithoutDuty;
    }
    public function coursesWithDutyForOutput(){
        $coursesWithoutDuty = $this->coursesWithDuty();
        if ($coursesWithoutDuty) {
            return implode('\n',$coursesWithoutDuty);
        } else{
            return 'Пусто';
        }
    }
}

// ваш код
$studentsInfo = 'Анна,Математика,85;Анна,Химия,90;Борис,Математика,75;Борис,История,80;Евгений,Математика,95';//trim(fgets(STDIN));
$coursesInfo = 'Математика,80;Химия,60;История,80';// trim(fgets(STDIN));

$cm = new CourseManager($studentsInfo, $coursesInfo);
$coursesWithoutDuty = $cm->coursesWithDuty();
