<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LD-2 1-dalis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<style>
		#table-div {
}

#form-div {
    width: 100%;
    margin: 40px auto auto;
}

#page-content {
    width: 50%;
    margin: auto;
}

.headline {
    text-align: center;
}

textarea {
    min-height: 100px;
}

#form-div button {
    width: 100%;
    margin-top: 20px;
}
	</style>
</head>
<body class="test">
<div id="page-content">
    <div id="table-div">
        <h2 class="headline">Žinutės</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <td scope="col">Nr.</td>
                <td scope="col">Kas siuntė</td>
                <td scope="col">Siuntėjo e-paštas</td>
                <td scope="col">Gavėjas</td>
                <td scope="col">Data (IP)</td>
                <td scope="col">Žinutė</td>
            </tr>
            </thead>
            <tbody>
            <?php		
			$db_connection = mysqli_connect("localhost", "root", "stud", "stud");
			if (!$db_connection)
   			 die("Mysql database unreachable: " . mysqli_error($db_connection));

		if ($_POST) {
   		 insert_message();
			}

		function get_messages()
		{
    		global $db_connection;

    		$sql = "SELECT * FROM audriusmaceina";
    		$result = mysqli_query($db_connection, $sql);
    		return mysqli_fetch_all($result);
		}

		function insert_message()
		{		
    		global $db_connection;

    		$current_date = date("Y-m-d");

   			 $ip = get_client_ip();
    		$sql = "INSERT INTO audriusmaceina (`vardas`, `epastas`, `zinute`, `kam`, `ip`, `data`) 
            VALUES ('{$_POST['vardas']}', '{$_POST['epastas']}', '{$_POST['zinute']}', '{$_POST['kam']}', '{$ip}', '{$current_date}')";
   			 var_dump($sql);
    		$result = mysqli_query($db_connection, $sql);

   			 if ($result == true)
        		header("Location: index.php");
    		else
        		var_dump($result);
		}

		function get_client_ip()
		{
    		return $_SERVER['REMOTE_ADDR'] === '::1' ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];
		}	

            $message = get_messages();
            foreach ($message as $msg) {
                echo "<tr>
                <td>{$msg[0]}</td>
                <td>{$msg[1]}</td>
                <td>{$msg[2]}</td>
                <td>{$msg[3]}</td>
                <td>{$msg[4]} {$msg[5]}</td>
                <td>{$msg[6]}</td>
              </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="form-div">
        <h2 class="headline">Įveskite naują žinutę</h2>
        <div class="form-group">
            <form method="post" action="index.php">
                <label for="vardas">Siuntėjo vardas</label>
                <input type="text" class="form-control" id="vardas" name="vardas" placeholder="Jūsų vardas" required>

                <label for="epastas">Siuntėjo e.paštas</label>
                <input type="email" class="form-control" id="epastas" name="epastas" placeholder="Jūsų e.paštas" required>

                <label for="kam">Kam skirta:</label>
                <input type="text" class="form-control" id="kam" name="kam"
                       placeholder="Gavėjas" required>

                <label for="zinute">Žinutė</label>
                <textarea name="zinute" id="zinute" class="form-control" placeholder="Žinutė" required></textarea>

                <button type="submit" class="btn btn-primary btn-lg"> Siųsti</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>