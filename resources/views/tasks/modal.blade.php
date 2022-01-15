<div class="modal fade" id="modalTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Task') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="" />
                <label for="project_id" class="col-form-label">{{ __('Project:') }}</label>
                <select class="form-select" id="project_id" name="project_id" required>
                    @foreach($projects as $project)
                        <option selected value="{{$project->id}}">{{$project->project}}</option>
                    @endforeach
                </select>
                <div class="form-group">
                    <label for="task" class="col-form-label">{{ __('Task:') }}</label>
                    <input type="text" class="form-control" id="task" name="task" required autocomplete="off">
                    <div style="color: red" id="messageValidade"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalTask" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" id="saveTask" class="btn btn-success btn-sm">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
