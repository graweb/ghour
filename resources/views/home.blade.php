@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{__('Dashboard')}}</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card-group">
                        <div class="col-lg-12">
                            @empty(!$projectHourValue)
                                <label for="current_project_id" class="col-form-label">{{ __('Current Project:') . ' ' }} <b>{{ $projectHourValue->project . ' - ' . ' Hour Value: '. $projectHourValue->currency . ' ' .  number_format($projectHourValue->hour_value, 2, ',','.') }}</b></label>
                                @if ($projectsActive > 1)
                                    <select class="form-select" id="current_project_id" name="current_project_id">
                                        <option selected disabled>Select</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" data="{{$project->hour_value}}">{{$project->project}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @else
                                @if (Auth::user()->type === 'Admin')
                                    @empty (!Auth::user()->current_project_id)
                                        <label for="current_project_id" class="col-form-label">{{ __('Current Project:') . ' ' }} <b>{{ $projectHourValue->project . ' - ' . ' Hour Value: '. $projectHourValue->currency . ' ' .  number_format($projectHourValue->hour_value, 2, ',','.') }}</b></label>
                                    @else
                                        <label for="current_project_id" class="col-form-label">{{ __('Current Project:') . ' ' }} <b>Please, you need to select a project</b></label>
                                    @endif

                                    <select class="form-select" id="current_project_id" name="current_project_id">
                                        <option selected disabled>Select</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" data="{{$project->hour_value}}">{{$project->project}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <label for="current_project_id" class="col-form-label">{{ __('Current Project:') . ' ' }} <b>Please, you need to create a project</b></label>
                                @endif
                            @endempty
                        </div>
                    </div>
                    <br>

                    <div class="card-group">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                All Projects Information
                                            </div>
                                            <div class="mb-0 text-gray-800">
                                                Total Active <b>{{$projectsActive}}</b><br>
                                                Total Inactive <b>{{$projectsInactive}}</b><br>
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Tasks by Current Project
                                            </div>
                                            <div class="mb-0 text-gray-800">
                                                Total Paid <b>{{$tasksPaid}}</b><br>
                                                Total Unpaid <b>{{$tasksUnpaid}}</b><br>
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Cost by Current Project
                                            </div>
                                            <div class="mb-0 text-gray-800">
                                                <?php
                                                    $i = 0;
                                                    $minutosTotal = array();
                                                    $horasTotal = array();
                                                    $horas = array();
                                                ?>
                                                @foreach ($tasks as $task)
                                                    <?php
                                                        $horas[$i] = $task->total_hours . ':' . $task->total_minutes;
                                                        $horasTotal[$i] = $task->total_hours;
                                                        $minutosTotal[$i] = $task->total_minutes;
                                                        $i++;
                                                    ?>
                                                @endforeach
                                                Hours
                                                <?php
                                                    $minutos = array_sum($minutosTotal);
                                                    $horas = floor($minutos / 60);
                                                    $minutos = $minutos % 60;
                                                    $exibe = array_sum($horasTotal)+$horas;
                                                    echo "<b>".$exibe.':'.$minutos."h</b>";
                                                ?>
                                                <br>
                                                Credit
                                                <?php
                                                    $minutos = array_sum($minutosTotal);
                                                    $horas = floor($minutos / 60);
                                                    $minutos = $minutos % 60;
                                                    $exibe = array_sum($horasTotal)+$horas;
                                                    echo "<b>".$minutos."m</b>";
                                                ?>
                                                <br>
                                                Total
                                                @empty(!$projectHourValue)
                                                    <?php
                                                        $minutos = array_sum($minutosTotal);
                                                        $horas = floor($minutos / 60);
                                                        $minutos = $minutos % 60;
                                                        $exibe = array_sum($horasTotal)+$horas;
                                                        echo "<b>".$projectHourValue->currency." ".number_format($exibe*$projectHourValue->hour_value, 2, ',','.')."</b>";
                                                    ?>
                                                @else
                                                    <?php
                                                        $minutos = array_sum($minutosTotal);
                                                        $horas = floor($minutos / 60);
                                                        $minutos = $minutos % 60;
                                                        $exibe = array_sum($horasTotal)+$horas;
                                                        echo "<b>".number_format($exibe*0, 2, ',','.')."</b>";
                                                    ?>
                                                @endempty

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>
<script type="text/javascript">
$('select').on('change', function(e){
    $.ajax({
        url : "{{route('user_update_update_current_project_id')}}",
        type : "post",
        data : {
            current_project_id : $('#current_project_id').val(),
            "_token" : "{{csrf_token()}}"
        },
        success : function (res) {
            $.notify(res.message,
                {
                    type:"success",
                    delay:1000,
                    animationType:"fade"
                },
            );

            setTimeout(function(){
                window.location.reload(1);
            }, 1000);
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
});
</script>

@endpush
@endsection
