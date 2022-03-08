<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>何時ですか？</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
	<header>
		<div id="logo">時間ピーカー</div>
	</header>
	<?php 
		include("config.php");
		include("datetime/datetime.php");
		require_once("datetime/db.php");

		// Init timezone list
		$timezone_identifiers = DateTimeZone::listIdentifiers();

		// Check if there's a POST request
		$adding_status = "";
		if (isset($_POST["localtz"]) && isset($_POST["dt"])) {
			$_POST["dt"][10] = ' ';
			date_default_timezone_set($_POST["localtz"]);
			$datetime = parseDatetime($_POST["dt"]);
			if (!$datetime) {
				$adding_status = "An error occured!";
			} else {
				$dtz = new DateTimeZone('Asia/Tokyo');
				$datetime->setTimezone($dtz);
				saveDatetime($conn, $datetime);
				$adding_status = "Added 1 record!";
			}
		}
		include("datetime/loader.php");
	?>
	<section>
		<form name = "register_form" action="" method="get">
			<table>
				<tr>
					<td>Input: &emsp;</td>
					<td><b>Local</b></td>
				</tr>
				<tr>
					<td>Display: &emsp;</td>
					<td>
						<select name="display">
							<?php foreach ($timezone_identifiers as $tz):
								if ($tz == "Asia/Hong_Kong"):
							?>
									<option value = "<?= $tz?>" selected = "selected"><?= $tz ?></option>
								<?php else: ?>
									<option value = "<?= $tz?>"><?= $tz ?></option>
							<?php endif;endforeach; ?>
						</select>
					</td>
					<td><input class="submit" type="submit" name="update" value="Update" /></td>
				</tr>
			</table>
		</form>

	</section>
	<section id="pageContent">
		<main role="main">
			<article>
				<h2>List</h2>
				<p>Total of result: <b><?= $load_datetime_result == null ? 0 : count($load_datetime_result)?></b></p>
				<br /><br />
				<table border="1">
					<thead>
						<th>ID&nbsp;</th>
						<th>Datetime</th>
					</thead>
					<tbody>
						<?php if ($load_datetime_result) {
							date_default_timezone_set("Asia/Tokyo");
							$display = $_GET['display'] ??  "Asia/Hong_Kong";
							$dtz = new DateTimeZone($display);
							foreach($load_datetime_result as $datetime): ?>
						<tr>
							<td><?= $datetime['id'] ?></td>
							<td><?= parseDatetime($datetime['datetime'])->setTimezone($dtz)->format('Y-m-d H:i:s')?> <i>_<?= $display ?> </i></td>
						</tr>
						<?php endforeach;}?>
					</tbody>
				</table>
			</article>
		</main>
		<aside>
			<div style="padding: 30px;">
			<p style="color:azure"> 
				<?= $adding_status ?>
			</p><br />
			<form name = "register_form" action="" method="post">
				<div class="form_settings">
						<select name="localtz">
							<?php foreach ($timezone_identifiers as $tz):
								if ($tz == "Asia/Ho_Chi_Minh"):
							?>
									<option value = "<?= $tz?>" selected = "selected"><?= $tz ?></option>
								<?php else: ?>
									<option value = "<?= $tz?>"><?= $tz ?></option>
							<?php endif;endforeach; ?>
						</select>
					<p><input type="datetime-local" name = "dt"></p>
					<p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="submit" name="name" value="送信" /></p>
				</div>
			</form>
			</div>
		</aside>
	</section>


</body>

</html>