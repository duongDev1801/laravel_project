<?php

namespace Modules\Category\src\Http\Controllers;


use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Modules\Category\src\Models\Category;
use Modules\Category\src\Http\Requests\CategoryRequest;
use Modules\Category\src\Repositories\CategoryRepository;
// use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
  protected $categoryRepo;
  public function __construct(CategoryRepository $categoryRepo)
  {
    $this->categoryRepo = $categoryRepo;
  }
  public function index()
  {
    $pageTitle = config('title.list');
    return view('category::list', compact('pageTitle'));
  }
  public function create()
  {
    $categories = $this->categoryRepo->getAllCategories();
    $pageTitle = config('title.create');
    return view('category::add', compact('pageTitle', 'categories'));
  }


  public function data()
  {

    $categories = $this->categoryRepo->getCategories();

    $data = DataTables::of($categories)
      ->addColumn('edit', function ($category) {
        return '<a href="' . route('admin.categories.edit', $category) . '" class="btn btn-warning">Sửa</a>';
      })
      ->addColumn('delete', function ($category) {
        return '<a href="' . route('admin.categories.delete', $category) . '" class="btn btn-danger delete-action">Xóa</a>';
      })
      ->addColumn('link', function ($category) {
        return '<a href="" class="btn btn-primary">Xem</a>';
      })
      ->editColumn('created_at', function ($category) {
        return Carbon::parse($category->created_at)->format('d/m/Y H:i:s');
      })

      ->rawColumns(['edit', 'delete', 'link'])
      ->toJson();
    return $data;
  }

  public function store(CategoryRequest $request)
  {
    $this->categoryRepo->create([
      'name' => $request->name,
      'slug' => $request->slug,
      'parent_id' => $request->parent_id,
    ]);

    return redirect()->route('admin.categories.index')->with([
      'msg' => config('messages.success.create'),
      'type' => 'success'
    ]);
  }

  public function edit(Category $category)
  {

    $pageTitle = config('title.edit');

    return view('category::edit', compact('category', 'pageTitle'));
  }

  public function update(CategoryRequest $request, Category $category)
  {

    $data = $request->except('_token', 'password', '_method');
    if ($request->password) {
      $data['password'] = Hash::make($request->password);
    }
    $this->categoryRepo->update($category->id, $data);
    return back()->with([
      'msg' => config('messages.success.update'),
      'type' => 'success'
    ]);
  }

  public function delete($id)
  {
    $this->categoryRepo->delete($id);
    return back()->with('msg', config('messages.success.delete'));
  }
}