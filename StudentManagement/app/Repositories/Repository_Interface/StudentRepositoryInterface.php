<?php
namespace App\Repositories\Repository_Interface;

interface StudentRepositoryInterface
{
    /**
     * Get students in range of age
     * @param $from
     * @param $to
     * @return mixed
     */
    public function findStudentByAgeRange($from, $to);

    /**
     * Get students by mobile service operator
     * @param $operator
     * @return mixed
     */
    public function findStudentByPhone($operator);

    /**
     * Get students completed all courses
     * @return mixed
     */
    public function completedStudent();

    /**
     * Get students
     * @return mixed
     */
    public function incompleteStudent();

    /**
     * Add new student
     * @return mixed
     */
    public function addStudent();

    /**
     *Send mail to dismiss student
     * @return mixed
     */
    public function sendMailForDismiss();
}
