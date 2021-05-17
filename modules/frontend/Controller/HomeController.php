<?php

namespace Modules\Frontend\Controller;

use Engine\Core\Facades\Session;
use Engine\Core\Http\Header;
use Engine\Core\Http\Request;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Header::send('Content-Type', 'application/json; charset=UTF-8');

        // echo json_encode(['message' => 'success', 'method' => Request::method()]);

        print_r($_GET);
        print_r($_SERVER);
    }
}
