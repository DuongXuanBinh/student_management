<?php
namespace App\Repositories\Repository_Interface;

use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    /**
     * Get students in range of age
     * @param Request $request
     * @return mixed
     */
    public function filterStudent(Request $request);

    /**

    public function sendMailForDismiss();

    /**
     * Student can update profile
     * @return mixed
     */

}
