<?php

namespace Modules\User\src\Http\Controllers;

use Illuminate\Support\Carbon;
use Modules\User\src\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\User\src\Http\Requests\UserRequest;
use Modules\User\src\Repositories\UserRepositoryInterface;
// use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  protected $userRepo;
  public function __construct(UserRepositoryInterface $userRepo)
  {
    $this->userRepo = $userRepo;
  }
  public function index()
  {
    $pageTitle = config('title.list');
    return view('user::list', compact('pageTitle'));
  }
  public function create()
  {
    $pageTitle = config('title.create');
    return view('user::add', compact('pageTitle'));
  }

  public function data()
  {

    $users = $this->userRepo->getAllUsers();
    // dd($users);
// dd($user->id, gettype($user->id));
    $data = DataTables::of($users)
      ->addColumn('edit', function ($user) {
        return '<a href="' . route('admin.users.edit', $user) . '" class="btn btn-warning">Sửa</a>';
      })
      ->addColumn('delete', function ($user) {
        return '<a href="' . route('admin.users.delete', $user) . '" class="btn btn-danger delete-action">Xóa</a>';
      })
      ->editColumn('created_at', function ($user) {
        return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
      })
      ->rawColumns(['edit', 'delete'])
      ->toJson();
    return $data;
  }

  public function store(UserRequest $request)
  {
    $this->userRepo->create([
      'name' => $request->name,
      'email' => $request->email,
      'group_id' => $request->group_id,
      'password' => Hash::make($request->password)
    ]);

    return redirect()->route('admin.users.index')->with([
      'msg' => config('messages.success.create'),
      'type' => 'success'
    ]);
  }

  public function edit(User $user)
  {

    $pageTitle = config('title.edit');
    if (!$user) {
      abort(404);
    }
    return view('user::edit', compact('user', 'pageTitle'));
  }

  public function update(UserRequest $request, User $user)
  {

    $data = $request->except('_token', 'password', '_method');
    if ($request->password) {
      $data['password'] = Hash::make($request->password);
    }
    $this->userRepo->update($user->id, $data);
    return back()->with([
      'msg' => config('messages.success.update'),
      'type' => 'success'
    ]);
  }

  public function delete($id)
  {
    $this->userRepo->delete($id);
    return back()->with('msg', config('messages.success.delete'));
  }
}