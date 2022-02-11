<div class="modal fade" id="modalCredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Credit') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="project_credit_id" class="col-form-label">{{ __('Project:') }}</label>
                <select class="form-select" id="project_credit_id" name="project_credit_id" required>
                    @foreach($projects as $project)
                        <option selected value="{{$project->id}}">{{$project->project}}</option>
                    @endforeach
                </select>
                <div class="form-group">
                    <label for="credit" class="col-form-label">{{ __('Credit: (minutes)') }}</label>
                    <input type="text" class="form-control" id="credit" name="credit" required autocomplete="off">
                    <div style="color: red" id="messageValidadeCredit"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalCredit" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" id="saveCredit" class="btn btn-success btn-sm">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
