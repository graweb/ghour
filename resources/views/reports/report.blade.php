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
		<h1 style="text-align:center"><strong style="font-size:30px">REPORT - ALL TASKS BY PROJECT</strong></h1>
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
					<th style="width:85%;font-size:11px">DESCRIPTION</th>
					<th style="width:15%;font-size:11px">STATUS</th>
				</tr>
			</thead>
			<tbody>
                <?php
                    $i = 0;
                ?>

                @foreach ($tasks as $task)
                    <tr>
                        <td style="font-size:11px">{{$task->task}}</td>
                        <td style="text-align:center; font-size:11px">
                            @if ($task->paid === 0)
                                <strong style="color:red">Unpaid</strong>
                            @else
                                <strong style="color:green">Paid</strong>
                            @endif
                        </td>
                    </tr>

                    <?php
						$i++;
                    ?>
                @endforeach
			</tbody>
		</table>
	</div>
</body>
</html>
