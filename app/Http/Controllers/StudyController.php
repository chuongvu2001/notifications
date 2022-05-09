<?php

namespace App\Http\Controllers;

use App\Jobs\JobStudy;
use App\Jobs\NewJob;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    //
    public function storeQueue()
    {
        $name = "Chun";
        $this->dispatch(new JobStudy($name));

        dd(1);
        return true;
    }
}
