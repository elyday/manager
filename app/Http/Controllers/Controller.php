<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function setSuccessMessage(string $message): void
    {
        $this->request->session()->flash('successMessage', $message);
    }

    protected function setErrorMessage(string $message): void
    {
        $this->request->session()->flash('errorMessage', $message);
    }
}
