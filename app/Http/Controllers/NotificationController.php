<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get a notification index page.
     *
     * @return PostCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications.index');
    }
}
