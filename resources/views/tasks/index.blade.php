@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ __('Tasks') }}</b>

                    <small class="float-sm-right">
                        <a onclick="newCredit()" class="btn btn-secondary btn-sm mr-2">{{ __('New Credit') }}</a>
                        <a onclick="newProject()" class="btn btn-primary btn-sm">{{ __('New Task') }}</a>
                    </small>
                </div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered table-hover" id="taskTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project</th>
                                    <th>Task</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    @if (Auth::user()->type === 'Admin')
                                        <th>Action</th>
                                    @else
                                        <th>Status</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('tasks.modal')
@include('tasks.modal_credit')
@include('tasks.modal_destroy')
@include('tasks.modal_stop')
@include('tasks.modal_paid')

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#taskTable').DataTable({
        serverside : true,
        responseive : true,
        ajax : {
            url : "{{route('tasks')}}"
        },
        columnDefs: [
            {
                "targets": 0,
                "className": "text-center",
                "visible": false,
            },
            {
                "targets": 1,
                "className": "text-left",
                "width": "10%"
            },
            {
                "targets": 2,
                "className": "text-left",
                "width": "50%"
            },
            {
                "targets": 3,
                "className": "text-center",
                "width": "15%"
            },
            {
                "targets": 4,
                "className": "text-center",
                "width": "15%"
            },
            {
                "targets": 5,
                "className": "text-center",
                "width": "10%",
                "orderable": false,
                "searchable": false,
            }
        ],
        "order": [[ 0, "desc" ]],
        columns:[
            {data: 'id', name: 'id'},
            {data: 'project', name: 'project'},
            {data: 'task', name: 'task'},
            {data: 'start_datetime', name: 'start_datetime'},
            {data: 'end_datetime', name: 'end_datetime'},
            {data: 'action', name: 'action'}
        ]
    });
});

/*$(document).ready(function() {
    var table = $('#taskTable').DataTable();

    $('#taskTable tbody').on('dblclick', 'tr', function () {
        var data = table.row(this).data();
        $('#id').val(data.id);
        $('#project_id').val(data.project_id);
        $('#task').val(data.task);
        $('#modalTask').modal('show');
    });
});*/

function newProject()
{
    $('#id').val('');
    $('#task').val('');
    $('#messageValidade').html('');
    $('#modalTask').modal('show');
}

$('#saveTask').on('click',function () {
    if($('#task').val() === '')
    {
        $('#messageValidade').html("Task is required");
    }
    else
    {
        $('#messageValidade').html("");
        if ($('#id').val() === '') {
            taskNew();
        } else {
            //taskEdit();
        }
    }
})

function taskNew() {
    $("#saveTask").attr("disabled", true);
    $("#saveTask").text("Sending mail...");
    $.ajax({
        url : "{{route('task_store')}}",
        type : "post",
        data : {
            project_id : $('#project_id').val(),
            task : $('#task').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalTask').click();
            $('#taskTable').DataTable().ajax.reload();
            $('#task').val(null);
            $("#saveTask").attr("disabled", false);
            $("#saveTask").text("Save");

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

/*$(document).on('click','.editTask', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('task_edit')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#id').val(res.data.id);
            $('#project_id').val(res.data.project_id);
            $('#task').val(res.data.task);
        }
    });
    $('#modalTask').modal('show');
});

function taskEdit() {
    $.ajax({
        url : "{{route('task_update')}}",
        type : "post",
        data : {
            id : $('#id').val(),
            project_id : $('#project_id').val(),
            task : $('#task').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalTask').click();
            $('#taskTable').DataTable().ajax.reload();
            $('#project_id').val(null);
            $('#task').val(null);
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

$('#saveTaskDestroy').on('click',function () {
    taskDestroy();
});

$(document).on('click','.destroyTask', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('task_remove')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#task_id_destroy').val(res.data.id);
        }
    });
    $('#modalDestroyTask').modal('show');
});

function taskDestroy() {
    $.ajax({
        url : "{{route('task_destroy')}}",
        type : "post",
        data : {
            id : $('#task_id_destroy').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalTaskDestroy').click();
            $('#taskTable').DataTable().ajax.reload();
            $('#task_id_destroy').val(null);

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
}*/

$('#saveTaskStop').on('click',function () {
    taskDone();
});

$(document).on('click','.stopTask', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('task_stop')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#task_id_stop').val(res.data.id);
            $('#project_id_stop').val(res.data.project_id);
            $('#task_stop').val(res.data.task);
        }
    });
    $('#modalStop').modal('show');
});

function taskDone() {
    $("#saveTaskStop").attr("disabled", true);
    $("#saveTaskStop").text("Sending mail...");
    $.ajax({
        url : "{{route('task_done')}}",
        type : "post",
        data : {
            id : $('#task_id_stop').val(),
            project_id_stop: $('#project_id_stop').val(),
            task_stop: $('#task_stop').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalTaskStop').click();
            $('#taskTable').DataTable().ajax.reload();
            $('#task_id_stop').val(null);
            $("#saveTaskStop").attr("disabled", false);
            $("#saveTaskStop").text("Save");

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

$('#saveTaskPaid').on('click',function () {
    taskFinish();
});

$(document).on('click','.paidTask', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('task_paid')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#task_id_paid').val(res.data.id);
        }
    });
    $('#modalPaid').modal('show');
});

function taskFinish() {
    $.ajax({
        url : "{{route('task_finish')}}",
        type : "post",
        data : {
            id : $('#task_id_paid').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closeModalTaskPaid').click();
            $('#taskTable').DataTable().ajax.reload();
            $('#task_id_paid').val(null);

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

function newCredit()
{
    $('#credit').val('');
    $('#messageValidadeCredit').html('');
    $('#modalCredit').modal('show');
}


$('#saveCredit').on('click',function () {
    if($('#credit').val() === '')
    {
        $('#messageValidadeCredit').html("Credit is required");
    }
    else
    {
        $("#saveCredit").attr("disabled", true);
        $.ajax({
            url : "{{route('task_credit')}}",
            type : "post",
            data : {
                project_credit_id : $('#project_credit_id').val(),
                credit : $('#credit').val(),
                "_token" : "{{csrf_token()}}"
            },
            success : function (res) {
                $('#closeModalCredit').click();
                $('#taskTable').DataTable().ajax.reload();
                $('#credit').val(null);
                $("#saveCredit").attr("disabled", false);
                $("#saveCredit").text("Save");

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
})
</script>
@endpush
@endsection
