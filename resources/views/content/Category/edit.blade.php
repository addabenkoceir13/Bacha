<!-- Modal -->
<div class="modal fade" id="modalEditBuilding-{{ $category->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">{{ __('Modify building materials') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('services.category.update', $category->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nameWithTitle" class="form-label">{{ __('Name') }}</label>
              <input type="text" id="nameWithTitle" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}">
              @error('name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="type" class="form-label">{{ __('Select type') }}</label>
              <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" placeholder="{{ __('Select type') }}">
                <option value="{{ $category->type }}">{{ $category->type }}</option>
                <option value="حبة">حبة</option>
                <option value="قنطار">قنطار</option>
              </select>
              @error('type')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
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
