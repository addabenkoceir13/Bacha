<!-- Modal -->
<div class="modal fade" id="modalEditSales-{{ $sale->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">{{ __('Modify Sales') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('sales.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="row g-2">
                <div class="col-md-6 mb-3">
                  <label for="category_id" class="form-label">{{ __('Select the item') }}</label>
                  <select id="category_id" class="form-select" name="category_id" required>
                    <option value="{{ $sale->category_id }}" selected>{{ $sale->name_product }}</option>
                    @foreach ($categories as $category)
                      <option value="{{ $category->id }}" data-name="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                    <span class="alert alert-danger " role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                  <input type="number"  step="0.01" id="quantity" name="quantity" min="0" class="form-control @error('quantity') is-invalid @enderror" value="{{ $sale->quantity }}" />
                  @error('quantity')
                    <span class="alert alert-danger " role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="amount" class="form-label">{{ __('Amount') }}</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">{{ __('DZ') }}</span>
                    <input type="number" name="amount" step="0.01" class="form-control @error('amount') is-invalid @enderror"  min="0" value="{{ $sale->amount }}"  required>
                    <span class="input-group-text">.00</span>
                  </div>
                  @error('amount')
                    <span class="alert alert-danger " role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-md-6 mt-5">
                  <div class="form-check">
                    <input type="hidden" name="is_debt" value="0"> <!-- Hidden input for unchecked value -->
                    <input class="form-check-input" type="checkbox" id="is_debt-edit-{{ $sale->id }}" name="is_debt" @checked($sale->is_debt)  value="1">
                    <label class="form-check-label" for="is_debt-edit-{{ $sale->id }}">
                        {{ __('Is there a debt?') }}
                    </label>
                  </div>
                </div>
              </div>

              <div class="divider divider-primary">
                <div class="divider-text">
                  <i class='bx bx-cube-alt'></i>
                </div>
              </div>

              <div class="row g-2 is-debt-fields-edit" id="is-debt-fields-edit" @if ($sale->is_debt != 1) style="display: none;"  @endif  >
                <div class="col-md-6 mb-3">
                  <label for="name_client" class="form-label">{{ __('Customer Name') }}</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-name_client2" class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" id="name_client-search" name="name_client" class="form-control @error('name_client') is-invalid @enderror" value="{{ $sale->name_client }}" />

                  </div>
                  @error('name_client')
                    <span class="alert alert-danger " role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label for="date_debt" class="form-label">{{ __('Date Debt') }}</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"><i class='bx bx-calendar-check'></i></span>
                    <input type="date" id="date_debt" name="date_debt"  class="form-control @error('date_debt') is-invalid @enderror" min="2020-01-01" value="{{ $sale->date_debt }}"  />
                  </div>
                  @error('date_debt')
                    <span class="alert alert-danger" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="notes"  class="form-label">{{ __('Note') }}</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                    <textarea name="notes" id="notes" class="form-control" placeholder="{{ __('Write your notes') }}">{{ $sale->notes }}</textarea>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>



