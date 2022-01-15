@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ __('Reports') }}</b>
                </div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered table-hover" id="reportTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
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

@include('reports.modal_print_invoice')
@include('reports.modal_print_report')

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#reportTable').DataTable({
        serverside : true,
        responseive : true,
        ajax : {
            url : "{{route('reports')}}"
        },
        columnDefs: [
            {
                "targets": 1,
                "className": "text-center",
                "width": "10%"
            }
        ],
        columns:[
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'}
        ]
    });
});

$(document).on('click','.printPdf', function () {
    let id = $(this).attr('id');

    if(id == 1)
    {
        $('#repot_id').val(id);
        $('#modalPrintInvoice').modal('show');
    }
    else
    {
        $('#repot_id').val(id);
        $('#modalPrintReport').modal('show');
    }
});
</script>
@endpush
@endsection
