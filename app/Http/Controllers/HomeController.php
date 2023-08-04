<?php

namespace App\Http\Controllers;

use App\Repositories\Team\TeamRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $teamRepository;


    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    public function index() {
        $teams = $this->teamRepository->getAll();

        return view('welcome', compact('teams'));
    }

    public function myCaptcha()
    {
        return view('myCaptcha');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function myCaptchaPost(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha'
        ],
        ['captcha.captcha'=>'Invalid captcha code.']);
        dd("You are here :) .");
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
