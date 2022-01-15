<div class="modal fade" id="modalDestroyUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        @csrf
        <input type="hidden" id="user_id_destroy" name="user_id_destroy" />
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attention</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="text-align: center"><b>{{ __('Do you want to remove this user?') }}</b></h6>
                <h6 style="text-align: center; color: red">{{ __('The Client, Projects and Tasks will also be removed.') }}</h6>
            </div>
            <div class="modal-footer">
                <button type="button" id="closemodalUserDestroy" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('No') }}</button>
                <button type="submit" id="saveUserDestroy" class="btn btn-success btn-sm">{{ __('Yes') }}</button>
            </div>
        </div>
    </div>
</div>
