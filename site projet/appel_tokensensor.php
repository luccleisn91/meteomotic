<?php




if (!empty($_POST))
{	
	if (!empty($_POST['validationtoken'])) 
	{	
		include_once 'bddsensor.php';
		
		$id=1; #on entre son ID et on compare avec bdd
		$basereq = $basesensor->prepare('SELECT * FROM stationmeteo');
		$basereq->execute();
		$info = $basereq->fetch();
		$tokenreq = $_POST['validationtoken'];

		if ($tokenreq == $info['tokensensor'])
		{
			echo "<br/>Ok";
			echo "<br/>",$info['temperature'],"<br/>",$info['date'];

		}
		else
		{
			echo "<br/>Pas ok";
		}
	}
}
else 
{
	echo "<br/>erreur";
}


?>

    <?php
    require_once 'fonction.php';
    require_once 'bddsensor.php';


    ?>

    <html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['line']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Heures');
                data.addColumn('number', 'Température');


                data.addRows([
                    <?php
                        $i = 1;
                    while($donnees_sensor = $basereq->fetch())
                    {
                        ?>
                    [ <?php echo $i; ?>   ,   <?php echo $donnees_sensor['temperature'];?> ]


                    <?php } ?>


                ]);

                var options = {
                    chart: {
                        title: 'Box Office Earnings in First Two Weeks of Opening',
                        subtitle: 'in millions of dollars (USD)'
                    },
                    width: 900,
                    height: 500,
                    axes: {
                        x: {
                            0: {side: 'top'}
                        }
                    }
                };

                var chart = new google.charts.Line(document.getElementById('line_top_x'));

                chart.draw(data, google.charts.Line.convertOptions(options));
            }
        </script>
    </head>
    <body>
    <div id="line_top_x"></div>
    </body>
    </html>

</div>
<div>

</div>


<?php
	require 'footer.php';
?>





