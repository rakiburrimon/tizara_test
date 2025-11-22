<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Traits\FileUploadTrait;

class ApiBaseController extends Controller
{
    use ApiResponseTrait;
    use FileUploadTrait;
}
