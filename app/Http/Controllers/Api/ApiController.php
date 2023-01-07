<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Respond with empty content.
     *
     * @return \Illuminate\Http\Response
     */
    public function noContent(): Response
    {
        return (new Response)
                ->setStatusCode(204);
    }    
}  