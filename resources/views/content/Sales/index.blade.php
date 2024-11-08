@extends('layouts/contentNavbarLayout')

@section('title', __('Sales'))

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">{{ __('Sales') }} /</span> {{ __('Sales') }}
</h4>

<div class="card p-2 mb-5">
  <h5 class="card-header">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSales">
      {{ __('Add Sales') }}
    </button>
  </h5>
  @include('content.Sales.create')
  <div class="table-responsive text-nowrap">
    <div class="row g-0">
      <div class="mb-3 col-md-4">
        <label for="statusFilter" class="form-label">{{ __('Filter by Status') }}</label>
        <select id="statusFilter" class="form-select">
            <option value="">{{ __('All') }}</option>
            <option value="Paid">{{ __('Paid') }}</option>
            <option value="Unpaid">{{ __('Unpaid') }}</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="dateFilter" class="form-label">{{ __('Filter by Date') }}</label>
        <div class="input-group input-group-merge">
          <span id="basic-icon-default-phone2" class="input-group-text"><i class='bx bx-calendar-check'></i></span>
          <input type="date" id="dateFilter"   class="form-control" min="2020-01-01" value="{{ $toDay }}"/>
        </div>
      </div>
    </div>
    <div id="salesTable">
      @include('content.Sales.table-filter', ['sales' => $sales])
    {{-- <table id="datatable-sales" class="table table-hover is-stripedt">
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

    </table> --}}
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>

<script>
  $(document).ready(function() {
      new DataTable('#datatable-sales', {
        initComplete: function () {
            let api = this.api();

            // Add Status Filter Dropdown
            $('#statusFilter').on('change', function () {
                let language = "{{ app()->getLocale() }}";
                let filterValue = $(this).val();
                console.log(language);
                console.log(filterValue);
                let column = api.column(5);
                if (language === 'ar') {
                  paid = "{{ __('Paid') }}"
                  unpaid = "{{ __('Unpaid') }}"
                  switch (filterValue){
                    case 'Paid':
                      column.search(paid, true, false).draw();
                      break;
                    case 'Unpaid':
                      column.search(unpaid, true, false).draw();
                      break;
                    default:
                      column.search('', true, false).draw();
                  }
                } else {
                  if (filterValue) {
                      api.column(7).search('^' + filterValue + '$', true, false).draw();
                  } else {
                      api.column(7).search('').draw();
                  }
                }
            });

            // Initialize text input search on each column footer
            api.columns().every(function () {
                let column = this;
                let title = column.footer() ? column.footer().textContent : '';

                // Create input element if title is present
                if (title) {
                    let input = document.createElement('input');
                    input.placeholder = title;
                    column.footer().replaceChildren(input);

                    // Event listener for input
                    input.addEventListener('keyup', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });
        }
      });
  });

  document.getElementById('is_debt').addEventListener('change', function() {
      if (this.checked) {
          $('#is-debt-fields').show()
      } else {
          $('#is-debt-fields').hide()
      }
  });

  $(document).on('change', '[id^=is_debt-edit-]', function() {
      let id = $(this).attr('id').split('-').pop(); // Extract the debt id from the button's ID
      console.log(id);

      if (this.checked) {
          $('.is-debt-fields-edit').show()
      } else {
          $('.is-debt-fields-edit').hide()
      }
  });

  $('#dateFilter').on('change', function() {
      // Get the selected date
      let selectedDate = $(this).val();

      // Send Ajax request to filter sales by date
      $.ajax({
          url: "{{ route('sales.index') }}", // Your route to the controller method
          method: 'GET',
          data: { date: selectedDate },
          success: function(response) {
              // Update the sales table with the filtered data
              $('#salesTable').html(response); // Update the sales table with the filtered data
          },
          error: function(xhr) {
              console.error('Error:', xhr.responseText);
          }
      });
  });

  document.getElementById('is_debt-edit').addEventListener('change', function() {


  });

</script>
@endsection
