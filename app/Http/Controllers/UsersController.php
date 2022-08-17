<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    public function __construct() {
        $this->middleware('role:1');
    }

    public function index(Request $request) {
        $users = User::orderBy(
            $request->sortField ?: 'id',
            $request->sortField ? (!$request->sortOrder ? 'desc' : 'asc') : 'asc'
        );

        if($request->search) {
            $columns = ['name', 'email'];
            foreach ($columns as $column) {
                $users = $users->orWhere('users.'.$column, 'LIKE', '%' . $request->search . '%');
            }
            $users->orWhereHas('roles', function($q) use($request){
                $q->whereIn('roles.name', [$request->search]);
            });
        }

        if ($request->trashed) {
            $users = $users->withTrashed();
        }

        return $this->sendResponse('Users retrieved successfully.', new UsersCollection($users->paginate($request->per_page ?: 5)));
    }

    public function store(UserRequest $request)
    {      
        $user = User::create(
            [
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]
        );

        $user->roles()->sync($request->roles);
   
        return $this->sendResponse('User created successfully.', new UsersResource($user));
    } 

    public function show($id)
    {
        $user = User::find($id);
  
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
   
        return $this->sendResponse('User retrieved successfully.', new UsersResource($user));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
  
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = $request->password;
        $user->save();

        $user->roles()->sync($request->roles);
   
        return $this->sendResponse('User updated successfully.', new UsersResource($user));
    }

    public function destroy($id)
    {
        $user = User::find($id);
  
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        $user->delete();
   
        return $this->sendResponse('User deleted successfully.', []);
    }
}
