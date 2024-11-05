<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Sales\SalesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    private $sales;
    private $category;

    public function __construct(SalesRepository $sales, CategoryRepository $category){
        $this->sales = $sales;
        $this->category = $category;
    }

    public function index()
    {
        $sales = $this->sales->paginate(10);
        $categories = $this->category->paginate(10);

        return view('content.sales.index', compact('sales', 'categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'quantity'    => 'required|numeric',
            'amount'      => 'required|nullable',
            'is_debt'     => 'required|boolean',
        ]);

        // Apply conditional validation for fields when is_debt is 1
        $validator->sometimes('name_client', 'required|string', function ($input) {
            return $input->is_debt == 1;
        });

        $validator->sometimes('notes', 'nullable|string', function ($input) {
            return $input->is_debt == 1;
        });

        $validator->sometimes('date_debt', 'required|date', function ($input) {
            return $input->is_debt == 1;
        });

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $isDebt = $request->input('is_debt');
            $category = $this->category->find($request->category_id);
            $data = array_replace([
                'category_id'   => $request->category_id,
                'name_product'  => $category->name,
                'quantity'      => $request->quantity,
                'amount'        => $request->amount,
                'is_debt'       => $isDebt,
            ]);

            if ($isDebt) {
                $data = array_replace($data, [
                  'name_client' => $request->name_client,
                  'notes' => $request->notes,
                  'date_debt' => $request->date_debt,
                  'type' => 'debt', // ** debt or normal
                  'status_debt' => 'unpaid',  // ** paid or unpaid
                ]);
                $sales = $this->sales->create( $data);
            } else {
                $sales = $this->sales->create($data);
            }

            DB::commit();
            return redirect()->back()->withSuccess(__('Debt added successfully'));

        }
        catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }


    }


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
