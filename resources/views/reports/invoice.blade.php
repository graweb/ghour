<!DOCTYPE html>
<html lang="en">
<head>
<title>Gtime</title>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.table {
	width: 100%;
}

th {
	background-color: #CCCCCC;
	font-weight: bold;
	text-align: center;
}

tfoot {
	font-weight: bold;
}
</style>
<body>
	<div>
		<h1 style="text-align:center"><strong style="font-size:30px">INVOICE</strong></h1>
		<p></p>
		<p></p>
        <p></p>
		<p></p>
        <table class="table">
			<tr>
				<td style="font-size:11px"><strong>{{ $userAdmin->company }}</strong></td>
			</tr>
			<tr>
				<td style="font-size:11px">{{ $userAdmin->address }}</td>
			</tr>
            <tr>
				<td style="font-size:11px">{{ $userAdmin->email }}<</td>
                <td style="font-size:11px" align="right"><strong>Data:</strong> <?php echo date('d/m/Y');?></td>
			</tr>
            <tr>
				<td style="font-size:11px">{{ $userAdmin->contact }}</td>
                <td style="font-size:11px" align="right"><strong>Due date</strong> <?php echo date('d/m/Y', strtotime('+1 month'));?></td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td colspan="2"></th>
			</tr>
			<tr>
				<td style="font-size:11px"><strong>BILL TO:</strong></td>
			</tr>
			<tr>
				<td style="font-size:11px"><strong>{{ $user->company }}</strong></td>
			</tr>
            <tr>
				<td style="font-size:11px">{{ $user->address }}</td>
			</tr>
			<tr>
				<td style="font-size:11px">{{ $user->contact }}</td>
			</tr>
		</table>
		<p></p>
		<table class="table">
			<thead>
				<tr>
					<th style="width:50%;font-size:11px">DESCRIPTION</th>
					<th style="width:10%;font-size:11px">PRICE</th>
					<th style="width:10%;font-size:11px">QUANTITY</th>
					<th style="width:10%;font-size:11px">AMOUNT*h</th>
				</tr>
			</thead>
			<tbody>
                <?php
                    $i = 0;
					$minutosTotal = array();
					$horasTotal = array();
					$horas = array();
                ?>

                @foreach ($tasks as $task)
                    <tr>
                        <td style="font-size:11px">{{$task->task}}</td>
                        @if ($project->currency === 'R$')
                            <td style="text-align:center; font-size:11px">{{ $project->currency . ' ' . $project->hour_value }}/h</td>
                        @else
                            <td style="text-align:center; font-size:11px">{{ $project->currency . ' ' . $project->hour_value }} CAD/h</td>
                        @endif
                        <td style="text-align:center; font-size:11px">{{ $task->total_hours}}:{{$task->total_minutes }}/h</td>
                        <td style="text-align:center; font-size:11px">{{ $project->currency . ' ' . number_format($task->total_hours*$project->hour_value, 2, ',','.') }}</td>
                    </tr>

                    <?php
                        $horas[$i] = $task->total_hours . ':' . $task->total_minutes;
						$horasTotal[$i] = $task->total_hours;
						$minutosTotal[$i] = $task->total_minutes;
						$i++;
                    ?>
                @endforeach
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
			</tbody>
			<tfoot>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align:right;"><strong style="font-size:11px">HOURS:</strong></td>
					<td style="text-align:center">
						<strong style="font-size:11px">
                        <?php
							$minutos = array_sum($minutosTotal);
							$horas = floor($minutos / 60);
							$minutos = $minutos % 60;
							$exibe = array_sum($horasTotal)+$horas;
							echo $exibe.':'.$minutos."h";
						?>
						</strong>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align:right;"><strong style="font-size:11px">CREDIT:</strong></td>
					<td style="text-align:center">
						<strong style="font-size:11px">
                        <?php
							$minutos = array_sum($minutosTotal);
							$horas = floor($minutos / 60);
							$minutos = $minutos % 60;
							$exibe = array_sum($horasTotal)+$horas;
							echo $minutos."m";
						?>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
			    	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
			    </tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-align:right;"><strong style="font-size:14px">TOTAL:</strong></td>
					<td style="text-align:center">
						<strong style="font-size:14px">
							<?php
								$minutos = array_sum($minutosTotal);
								$horas = floor($minutos / 60);
								$minutos = $minutos % 60;
								$exibe = array_sum($horasTotal)+$horas;
								echo $project->currency . ' ' . number_format($exibe*$project->hour_value, 2, ',','.');
							?>
						</strong>
					</td>
			    </tr>
			</tfoot>
		</table>
		<p></p>
		<p></p>
        <hr>
		<table class="table">
			<tr>
				<td style="font-size:11px"><strong>ACCOUNT</strong></td>
			</tr>
			<tr>
				<td style="font-size:11px">Bank: 077 - Inter</td>
			</tr>
			<tr>
				<td style="font-size:11px">Branch: 0001</td>
			</tr>
			<tr>
				<td style="font-size:11px">Account: 002942078-4</td>
			</tr>
			<tr>
				<td style="font-size:11px">Name: Gustavo Grativol da Silva - CPF 116.313.217-90</td>
			</tr>
			<tr>
				<td style="font-size:11px">CNPJ: 22.848.379/0001-27 (PIX)</td>
			</tr>
		</table>
	</div>
</body>
</html>
