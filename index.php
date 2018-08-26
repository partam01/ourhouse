<?php include('_initialize.php') ?>

<?php

  // $users = find_house_users();
  $dat = find_tasks();
  $mytasks = find_my_tasks();
?>

<!-- this will call a php function to update task to done when checkbox is set -->
<?php
  if (isset($_GET['doneid'])) {
    echo set_task_to_done($_GET['doneid']);?>
    <script type="text/javascript">
    RefreshDashboard();
    </script>

<?php } ?>

<html lang="en">
<head>
	<title>Home</title>
	<script src="//d3js.org/d3.v3.min.js"></script>
</head>
<body>
	<section id="Calendar">
		<div class="header">
			<h2 class="section header">Home Page</h2>
		</div>
		<div class="calendar">
			<div data-tockify-component="mini" data-tockify-calendar="polina.artamonova"></div>
			<script data-cfasync="false" data-tockify-script="embed" src="https://public.tockify.com/browser/embed.js"></script>	
		</div>
		<nav id="OpenCalendar">
	    	<a href="#" class="menu_btn">Events</a>
	  	</nav>
	</section>

	<section id="Leaderboard">
		<div class="header">
			<h2 class="section header">Leaderboard</h2>
		</div>
		<div>
			<!-- this will be a graph of leadership who owns how many done tasks -->
			<!-- <svg class="chart" onload = "create_graph('<?php echo json_encode($dat); ?>')"></svg> -->

			<svg class="chart"></svg>
			<script>
				var data = <?php echo json_encode($dat); ?>;
				var width = 420,
				    barHeight = 20;

				var x = d3.scale.linear()
				    .range([0, width]);

				var chart = d3.select(".chart")
				    .attr("width", width);

				  x.domain([0, d3.max(data, function(d) { return d.value; })]);

				  chart.attr("height", barHeight * data.length);

				  var bar = chart.selectAll("g")
				      .data(data)
				    .enter().append("g")
				      .attr("transform", function(d, i) { return "translate(0," + i * barHeight + ")"; });

				  bar.append("rect")
				      .attr("width", function(d) { return x(d.value); })
				      .attr("height", barHeight - 1);

				  bar.append("text")
				      .attr("x", function(d) { return x(d.value) - 3; })
				      .attr("y", barHeight / 2)
				      .attr("dy", ".35em")
				      .text(function(d) { return d.name;});

				function type(d) {
				  d.value = +d.value; // coerce to number
				  return d;
				}
			</script>

		</div>

	</section>

	<section class="task_display" id="DashboardOTasks"> 
    <h2 class="section header">My Open Tasks</h2> 
    <div id="myTaskQuickView"> 
	    <table class="section table">
	      <thead class="section t-head">
	        <tr>
	          <th>Task name</th>
	          <th>Due date</th>
	          <th>Done</th>
	        </tr>
	     </thead>
	      <tbody id="MyOTaskResults">
	        <?php while($mytask = mysqli_fetch_assoc($mytasks)) { ?>
	                <tr>
	                  <td > <a href="tasks.php?id=<?php echo $mytask['id']; ?>"> <?php echo $mytask['name']; ?> </a>  </td>
	                  <td><?php echo $mytask['due_date']; ?></td> 
	                  <td><input type="checkbox"  onclick="DashboardSetToDone('<?php echo $mytask['id']; ?>')" />&nbsp;</td>
	                </tr>
	        <?php } ?>
	      </tbody>
	    </table>
    </div>
    <nav id="OpenTasks">
	    	<a href="tasks.php" class="menu_btn">Events</a>
	</nav>
  </section>
	
</body>
</html>
