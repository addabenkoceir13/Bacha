<div class="modal fade" id="modalPaySales-{{ $sale->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">{{ __('Pay a Sales') }} | {{ $sale->name_product }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('sales.pays',  $sale->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          {{ __('Do you really want to pay this sales?') }}" {{ $sale->name_product }} {{  $sale->name_client != null ? $sale->name_client : ''}}"
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
          <button type="submit" class="btn btn-outline-primary">{{ __('Pay') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>


