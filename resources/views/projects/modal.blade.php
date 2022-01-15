<div class="modal fade" id="modalProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Project') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="" />

                @if (Auth::user()->type === 'Admin')
                    <label for="user_id" class="col-form-label">{{ __('Client:') }}</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option selected value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
                @endif
                <div class="form-group">
                    <label for="project" class="col-form-label">{{ __('Project:') }}</label>
                    <input type="text" class="form-control" id="project" name="project" required autocomplete="off">
                </div>
                <label for="currency" class="col-form-label">{{ __('Currency:') }}</label>
                <select class="form-select" id="currency" name="currency">
                    <option selected value="R$">{{ __('Real') }}</option>
                    <option value="$">{{ __('Dólar') }}</option>
                </select>
                <div class="form-group">
                    <label for="hour_value" class="col-form-label">{{ __('Hour Value:') }}</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="numner" class="form-control" id="hour_value" name="hour_value" required autocomplete="off">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <label for="status" class="col-form-label">{{ __('Status:') }}</label>
                <select class="form-select" id="status" name="status">
                    <option selected value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Inactive') }}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalProject" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" id="saveProject" class="btn btn-success btn-sm">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
