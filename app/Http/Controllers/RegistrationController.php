<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;


use honeysec\User;

use Illuminate\Support\Facades\Hash;



class RegistrationController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('guest');
    }


    public function create()
    {
    	return view('registration.create');
    }



    public function store()
    {

       // dd(request()->all());

       // $userid =  hash("sha256",request('user_id'));


    	//validate the user
    	$this->validate(request(), [


    		'school' => 'required',

    		'favpet' => 'required',

    		'age' => 'required|numeric',



    		]);

        $users = User::all();

        $matched = false;

        foreach ($users as $user) 
        {
            
            //echo $user->user_id;

            if(Hash::check(request('user_id'), $user->user_id))
            {
                echo "Matched with one";
                $matched = true;
                break;

            }


        }

        if($matched==false)
        {
            // create the user and save

            $user = User::create(request(['user_id']));


            //sign the user in
            auth()->login($user);

            // session variable

            //dd($user->user_id);
            session('user_id', '');
            session(['user_id' => $user->user_id ]);
             session()->flash('message' , 'Thank you so much for registering');
            //dd(session('user_id', ''));


            return redirect()->home();


        }
        else
        {
            return redirect()->back()->withErrors([

                'message' => 'You are already registered'

                ]);
        }

       // dd($users);






    	
    	// redirect to the instructions page


    	




    }
}
