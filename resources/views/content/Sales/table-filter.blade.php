<table id="datatable-sales" class="table table-hover is-stripedt">
  <thead>
      <tr>
          <th>#</th>
          <th>{{ __('The item') }}</th>
          <th>{{ __('Quantity') }}</th>
          <th>{{ __('Amount') }}</th>
          <th>{{ __('Debt Status') }}</th>
          <th>{{ __('Customer Name') }}</th>
          <th>{{ __('Payment status') }}</th>
          <th>{{ __('Create At') }}</th>
          <th>{{ __('Action') }}</th>
      </tr>
  </thead>
  <tbody>
    @foreach ($sales as $sale)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $sale->name_product }}</td>
        <td>{{ $sale->quantity }}</td>
        <td>{{ $sale->amount }}</td>
        @if ($sale->is_debt)
          <td>
            @if ($sale->is_debt)
              <span class="badge bg-label-success">
                {{ __('Yes') }}
              </span>
            @else
              <span class="badge bg-label-gray">
                {{ __('Yes') }}
              </span>
            @endif
          </td>
          <td>{{ $sale->name_client }}</td>
          <td>
            @if ($sale->status_debt == 'paid')
              <span class="badge bg-label-success">
                {{ __('Paid') }}
              </span>
            @else
              <span class="badge bg-label-warning">
                {{ __('Unpaid') }}
              </span>
            @endif
          </td>
        @else
          <td>/</td>
          <td>/</td>
          <td>/</td>
        @endif
        <td>{{ $sale->created_at->format('d-m-Y') }}</td>
        <td>
          <button  type="button" class="btn btn-sm  btn-none" data-bs-toggle="modal" data-bs-target="#modalEditSales-{{ $sale->id }}">
            <span class="badge bg-label-success" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<i class='bx bx-edit-alt bx-xs' ></i> <span>{{ __('Modify Sales') }}</span>">
              <i class="bx bx-edit-alt me-1"></i>
            </span>
          </button>
          @include('content.Sales.edit')
          <button type="button" class="btn btn-sm btn-none" data-bs-toggle="modal" data-bs-target="#modalDeleteSales-{{ $sale->id }}">
            <span class="badge bg-label-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<i class='bx bx-trash bx-xs' ></i> <span>{{ __('Delete Sales') }}</span>">
              <i class="bx bx-trash me-1"></i>
            </span>
          </button>
          @include('content.Sales.delete')
          @if ($sale->is_debt)
            <button type="button" class="btn btn-sm btn-none" data-bs-toggle="modal" data-bs-target="#modalPaySales-{{ $sale->id }}">
              <span class="badge bg-label-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<i class='bx bx-bell bx-xs' ></i> <span>{{ __('Pay a Sales') }}</span>">
              <i class='bx bx-money'></i></span>
            </button>
            @include('content.Sales.pay')
          @endif
        </td>
    </tr>
    @endforeach
  </tbody>

</table>
