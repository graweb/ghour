<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('User') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="" />
                <div class="form-group">
                    <label for="name" class="col-form-label">{{ __('Name:') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">{{ __('Email:') }}</label>
                    <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                </div>
                <div class="form-group" id="divPass" name="divPass">
                    <label for="password" class="col-form-label">{{ __('Password:') }}</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="company" class="col-form-label">{{ __('Company:') }}</label>
                    <input type="text" class="form-control" id="company" name="company" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="address" class="col-form-label">{{ __('Address:') }}</label>
                    <input type="text" class="form-control" id="address" name="address" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="contact" class="col-form-label">{{ __('Contact Name and Cellphone:') }}</label>
                    <input type="text" class="form-control" id="contact" name="contact" required autocomplete="off">
                </div>
                <label for="type" class="col-form-label">{{ __('Type:') }}</label>
                <select class="form-select" id="type" name="type">
                    <option selected value="Admin">{{ __('Admin') }}</option>
                    <option value="Client">{{ __('Client') }}</option>
                </select>
                <label for="status" class="col-form-label">{{ __('Status:') }}</label>
                <select class="form-select" id="status" name="status">
                    <option selected value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Inactive') }}</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="closemodalUser" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" id="saveUser" class="btn btn-success btn-sm">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
