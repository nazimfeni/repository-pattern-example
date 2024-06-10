<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    

    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function index()
    {
  
      $users = $this->userRepository->all();
        return view('users.index', compact('users'));
    }



    public function create()
    {
  
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        // Hash the password before storing
       $data['password'] = Hash::make($data['password']);
        $this->userRepository->create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }


    public function show($id)
    {


        $user= $this->userRepository->find($id);
        //  dd($user);
        return view('users.show', compact('user'));
    }


    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('users.edit', compact('user'));
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|max:255', // Allow the password to be nullable
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']); // Do not update the password if it's not provided
        }

        $this->userRepository->update($id, $data);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }



    public function destroy($id)
    {
      $user= $this->userRepository->find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }


}



      

