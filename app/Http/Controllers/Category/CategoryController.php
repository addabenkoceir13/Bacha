<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }
    public function index()
    {
        $categories = $this->category->paginate(10);

        return view('content.Category.index', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'name' => ['required','string','max:255'],
        'type' => ['required','string','max:255'],
      ]);

      if ($validator->fails()){
        toastr()->error($validator->errors()->first());
        return redirect()->back()->withErrors($validator)->withInput();
      }
      try {
        $this->category->create($request->all());
        toastr()->success(__('Building materials successfully created'));
        return redirect()->back();
      }
      catch (\Exception $e) {
        toastr()->error($e->getMessage());
        return redirect()->back();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
