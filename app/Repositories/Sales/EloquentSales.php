<?php

namespace App\Repositories\Sales;

use App\Models\Sale;
use App\Repositories\Sales\SalesRepository;



class EloquentSales implements SalesRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Sale::all();
    }
    public function filterBydate($date)
    {
        return Sale::whereDate('created_at', $date)->orderBy('id', 'desc')->get();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Sale::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $Sale = Sale::create($data);

        return $Sale;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $Sale = $this->find($id);

        $Sale->update($data);

        return $Sale;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $Sale = $this->find($id);

        return $Sale->delete();
    }

    /**
     * @param $perPage
     * @param $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage = null, $search = null)
    {
        $query = Sale::query();

        $result = $query->orderBy('id', 'desc')
            ->get();

        return $result;
    }
}
