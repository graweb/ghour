<div class="modal fade" id="modalPaid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        @csrf
        <input type="hidden" id="task_id_paid" name="task_id_paid" />
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="text-align: center"><b>{{ __('Do you want to paid this task?') }}</b></h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalTaskPaid" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('No') }}</button>
                <button type="submit" id="saveTaskPaid" class="btn btn-success btn-sm">{{ __('Yes') }}</button>
            </div>
        </div>
    </div>
</div>