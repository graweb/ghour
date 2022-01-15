<div class="modal fade" id="modalPrintReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{route('report_pdf')}}" target="_blank">
            @csrf
            <input type="hidden" id="repot_id" name="repot_id" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Report - All Tasks by Project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="project_id" class="col-form-label">{{ __('Project:') }}</label>
                    <select class="form-select" id="project_id" name="project_id" required>
                        @foreach($projects as $project)
                            <option selected value="{{$project->id}}">{{$project->project}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-success btn-sm">{{ __('Print') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
