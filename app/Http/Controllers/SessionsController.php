<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

use honeysec\User;
use Illuminate\Support\Facades\Hash;




class SessionsController extends Controller
{
    //


    public function __construct()
    {
    	$this->middleware('guest')->except(['destroy']);
    }



    public function create()
    {
    	return view('sessions.create');
    }




    public function store()
    {

    	//dd(request()->all());

    	// attempt to auth the user
    	//if(! auth()->attempt(request(['user_id'])))
    	//{
    	//	return back()->withErrors([

    	//		'message' => 'pleasae check your credentials'

    	//		]);
    //	}

        //dd(auth()->user()->id);





        $users = User::all();

        $matched = false;

        foreach ($users as $user) 
        {
            
            //echo $user->user_id;

            if(Hash::check(request('user_id'), $user->user_id))
            {
               // echo "Matched with one";
                $matched = true;
                auth()->login($user);

                //session variable 

                session('user_id', '');
                session(['user_id' => $user->user_id ]);
                session()->flash('message' , 'Welcome! You are now logged in');
                //dd(session('user_id', ''));

                break;

            }


        }

        if($matched==false)
        {
           

            return redirect()->back()->withErrors([

                'message' => 'Check your credentials'

                ]);


        }
        


   


    	return redirect()->home();



    }



    public function destroy()
    {


    	auth()->logout();

        session()->flash('message' , 'You are successfully logged out');

    	return redirect()->home();

    }

    public function username()
    {
        return 'user_id';
    }
}
