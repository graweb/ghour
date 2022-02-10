@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ __('Users') }}</b>

                    <small class="float-sm-right">
                        <a onclick="newUser()" class="btn btn-primary btn-sm">{{ __('New User') }}</a>
                    </small>
                </div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered table-hover" id="userTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
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

@include('users.modal')
@include('users.modal_destroy')

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#userTable').DataTable({
        serverside : true,
        responseive : true,
        ajax : {
            url : "{{route('users')}}"
        },
        columnDefs: [
            {
                "targets": 3,
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": 4,
                "className": "text-center",
                "width": "10%"
            },
            {
                "targets": 4,
                "orderable": false,
                "searchable": false,
            }
        ],
        columns:[
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'type', name: 'type'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'}
        ]
    });
});

$(document).ready(function() {
    var table = $('#userTable').DataTable();

    $('#userTable tbody').on('dblclick', 'tr', function () {
        var data = table.row(this).data();
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.email);
        $('#company').val(data.company);
        $('#address').val(data.address);
        $('#contact').val(data.contact);
        if(data.type == 'Admin')
        {
            $('#type').val('Admin');
        }
        else
        {
            $('#type').val('Client');
        }
        if(data.status == '<span class="badge bg-success">Active</span>')
        {
            $('#status').val(1);
        }
        else
        {
            $('#status').val(0);
        }

        $('#divPass').hide();
        $('#modalUser').modal('show');
    });
} );

function newUser()
{
    $('#id').val('');
    $('#name').val('');
    $('#email').val('');
    $('#password').val('');
    $('#company').val('');
    $('#address').val('');
    $('#contact').val('');
    $('#modalUser').modal('show');
}

$('#saveUser').on('click',function () {
    if ($('#id').val() === '') {
        userNew();
    } else {
        userEdit();
    }
});

function userNew() {
    $.ajax({
        url : "{{route('user_store')}}",
        type : "post",
        data : {
            name : $('#name').val(),
            email : $('#email').val(),
            password : $('#password').val(),
            company : $('#company').val(),
            address : $('#address').val(),
            contact : $('#contact').val(),
            type : $('#type').val(),
            status : $('#status').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closemodalUser').click();
            $('#userTable').DataTable().ajax.reload();
            $('#name').val(null);
            $('#email').val(null);
            $('#password').val(null);
            $('#company').val(null);
            $('#address').val(null);
            $('#contact').val(null);
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

$(document).on('click','.editUser', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('user_edit')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#id').val(res.data.id);
            $('#name').val(res.data.name);
            $('#email').val(res.data.email);
            $('#company').val(res.data.company);
            $('#address').val(res.data.address);
            $('#contact').val(res.data.contact);
            $('#type').val(res.data.type);
            $('#status').val(res.data.status);

            $('#divPass').hide();
        }
    });
    $('#modalUser').modal('show');
});

function userEdit() {
    $.ajax({
        url : "{{route('user_update')}}",
        type : "post",
        data : {
            id : $('#id').val(),
            name : $('#name').val(),
            email : $('#email').val(),
            company: $('#company').val(),
            address: $('#address').val(),
            contact: $('#contact').val(),
            type : $('#type').val(),
            status : $('#status').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closemodalUser').click();
            $('#userTable').DataTable().ajax.reload();
            $('#name').val(null);
            $('#email').val(null);
            $('#company').val(null);
            $('#address').val(null);
            $('#contact').val(null);
            $('#type').val(null);
            $('#status').val(null);

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

$('#saveUserDestroy').on('click',function () {
    userDestroy();
});

$(document).on('click','.destroyUser', function () {
    let id = $(this).attr('id');
    $.ajax({
        url : "{{route('user_remove')}}",
        type : 'post',
        data : {
            id : id,
            _token : "{{csrf_token()}}"
        },
        success: function (res) {
            $('#user_id_destroy').val(res.data.id);
        }
    });
    $('#modalDestroyUser').modal('show');
});

function userDestroy() {
    $.ajax({
        url : "{{route('user_destroy')}}",
        type : "post",
        data : {
            id : $('#user_id_destroy').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $('#closemodalUserDestroy').click();
            $('#userTable').DataTable().ajax.reload();
            $('#user_id_destroy').val(null);

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
