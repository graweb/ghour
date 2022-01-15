@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ __('Projects') }}</b>

                    <small class="float-sm-right">
                        <a onclick="newProject()" class="btn btn-primary btn-sm">{{ __('New Project') }}</a>
                    </small>
                </div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered table-hover" id="projectTable">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Project</th>
                                    <th>Hour Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('projects.modal')
@include('projects.modal_destroy')

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#projectTable').DataTable({
        serverside : true,
        responseive : true,
        ajax : {
            url : "{{route('projects')}}"
        },
        columnDefs: [
            {
                "targets": 2,
                "className": "text-center",
                "width": "13%"
            },
            {
                "targets": 3,
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": 4,
                "className": "text-center",
                "width": "10%"
            }
        ],
        columns:[
            {data: 'name', name: 'name'},
            {data: 'project', name: 'project'},
            {data: 'hour_value', name: 'hour_value'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'}
        ]
    });
});

$(document).ready(function() {
    var table = $('#projectTable').DataTable();

    $('#projectTable tbody').on('dblclick', 'tr', function () {
        var data = table.row(this).data();
        $('#id').val(data.id);
        $('#user_id').val(data.user_id);
        $('#project').val(data.project);
        if(data.currency == 'R$')
        {
            $('#currency').val('R$');
        }
        else
        {
            $('#currency').val('$');
        }
        $('#hour_value').val(data.hour_value);
        if(data.status == '<span class="badge bg-success">Active</span>')
        {
            $('#status').val(1);
        }
        else
        {
            $('#status').val(0);
        }
        $('#modalProject').modal('show');
    } );
} );

function newProject()
{
    $('#id').val('');
    $('#project').val('');
    $('#hour_value').val('0');
    $('#modalProject').modal('show');
}

$('#saveProject').on('click',function () {
    if ($('#id').val() === '') {
        projectNew();
    } else {
        projectEdit();
    }
})

function projectNew() {
    $("#saveProject").attr("disabled", true);
    $("#saveProject").text("Sending mail...");
    $.ajax({
        url : "{{route('project_store')}}",
        type : "post",
        data : {
            user_id : $('#user_id').val(),
            project : $('#project').val(),
            currency: $('#currency').val(),
            hour_value: $('#hour_value').val(),
            status : $('#status').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalProject').click();
            $('#projectTable').DataTable().ajax.reload();
            $('#project').val(null);
            $('#currency').val(null);
            $('#hour_value').val(null);
            $("#saveProject").attr("disabled", false);
            $("#saveProject").text("Save");

            $.notify(res.message,
                {
                    type:"success",
                    delay:1000,
                    animationType:"fade"
                },
            );
        },
        error : function (xhr) {
            $.notify(xhr.responJson.message,
                {
                    type:"danger",
                    delay:1000,
                    animationType:"fade"
                },
            );
        }
    });
}

$(document).on('click','.editProject', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('project_edit')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#id').val(res.data.id);
            $('#user_id').val(res.data.user_id);
            $('#project').val(res.data.project);
            $('#currency').val(res.data.currency);
            $('#hour_value').val(res.data.hour_value);
            $('#status').val(res.data.status);
        }
    });
    $('#modalProject').modal('show');
});

function projectEdit() {
    $.ajax({
        url : "{{route('project_update')}}",
        type : "post",
        data : {
            id : $('#id').val(),
            user_id : $('#user_id').val(),
            project : $('#project').val(),
            currency : $('#currency').val(),
            hour_value : $('#hour_value').val(),
            status : $('#status').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalProject').click();
            $('#projectTable').DataTable().ajax.reload();
            $('#user_id').val(null);
            $('#project').val(null);
            $('#hour_value').val(null);
            $.notify(res.message,
                {
                    type:"success",
                    delay:1000,
                    animationType:"fade"
                },
            );
        },
        error : function (xhr) {
            $.notify(xhr.responJson.message,
                {
                    type:"danger",
                    delay:1000,
                    animationType:"fade"
                },
            );
        }
    });
}

$('#saveProjectDestroy').on('click',function () {
    projectDestroy();
});

$(document).on('click','.destroyProject', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('project_remove')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#project_id_destroy').val(res.data.id);
        }
    });
    $('#modalDestroyProject').modal('show');
});

function projectDestroy() {
    $.ajax({
        url : "{{route('project_destroy')}}",
        type : "post",
        data : {
            id : $('#project_id_destroy').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalProjectDestroy').click();
            $('#projectTable').DataTable().ajax.reload();
            $('#project_id_destroy').val(null);

            $.notify(res.message,
                {
                    type:"success",
                    delay:1000,
                    animationType:"fade"
                },
            );
        },
        error : function (xhr) {
            $.notify(xhr.responJson.message,
                {
                    type:"danger",
                    delay:1000,
                    animationType:"fade"
                },
            );
        }
    });
}
</script>
@endpush
@endsection
