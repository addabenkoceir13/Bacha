<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
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

    public function index(Request $request)
    {
        $toDay = now()->format('Y-m-d');
        $categories = $this->category->paginate(10);

        // Return a view or partial view with the sales data
        if ($request->ajax()) {
            $sales = $this->sales->filterBydate($request->date);
            return view('content.Sales.table-filter', compact('sales','categories', 'toDay'))->render();
        }
        $sales = $this->sales->filterBydate($toDay);

        return view('content.sales.index', compact('sales', 'categories', 'toDay'));
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
                  'notes'       => $request->notes,
                  'date_debt'   => $request->date_debt,
                  'type'        => 'debt', // ** debt or normal
                  'status_debt' => 'unpaid',  // ** paid or unpaid
                ]);
                $sales = $this->sales->create( $data);
            } else {
                $sales = $this->sales->create($data);
            }

            DB::commit();
            return redirect()->back()->withSuccess(__('Sales added successfully'));

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

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
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
                'notes'       => $request->notes,
                'date_debt'   => $request->date_debt,
                'type'        => 'debt', // ** debt or normal
                'status_debt' => 'unpaid',  // ** paid or unpaid
              ]);
              $sales = $this->sales->update( $id,$data);
          } else {
            $data = array_replace($data, [
              'name_client' => null,
              'notes'       => null,
              'date_debt'   => null,
              'type'        => 'normal', // ** debt or normal
              'status_debt' => 'unpaid',  // ** paid or unpaid
            ]);
              $sales = $this->sales->update($id,$data);
          }

          DB::commit();
          return redirect()->back()->withSuccess(__('Sales updated successfully'));

      }
      catch (\Exception $e) {
          DB::rollBack();
          toastr()->error($e->getMessage());
          return redirect()->back();
      }
    }

    public function destroy($id)
    {
        try {
          DB::beginTransaction();
          $this->sales->delete($id);
          DB::commit();
          return redirect()->back()->withSuccess(__('Sales deleted successfully'));
        }
        catch (\Exception $e) {
          DB::rollBack();
          toastr()->error($e->getMessage());
          return redirect()->back();
      }
    }

    public function pays($id)
    {
      try {
        DB::beginTransaction();
        $data = array_replace( [
          'status_debt' => 'paid',  // ** paid or unpaid
        ]);
        $this->sales->update($id, $data);
        DB::commit();
        return redirect()->back()->withSuccess(__('Sales updated successfully'));
      }
      catch (\Exception $e) {
        DB::rollBack();
        toastr()->error($e->getMessage());
        return redirect()->back();
      }

    }
}
