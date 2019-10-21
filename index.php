<html>
<!-- Do whatever you want with this.
I've created this program to get better with PHP & because I was bored.

Yes, I know this is just reading some basic text from a json file hosted on the web. Deal with it.

~MrWouter -->
<head>
	<?php
	if(empty($_POST['server'])){
		$titleip = "Server Info Checker";
	}else{
	 $titleip = "Checking ".$_POST['server'];
	}
	?>
  <title><?php echo $titleip; ?> </title>
	<link rel="icon" href="https://www.spigotmc.org/data/avatars/l/73/73076.jpg">
</head>
<body>
     <form method="post">
        <input type="text" name="server" placeholder="play.my-coolserver.com" >
        <input type="submit" name="submit" value="Request information">
     </form>
</body>
</html>
<?php
    if(isset($_POST['submit'])){
      if(empty($_POST['server'])) {
        echo "<p>No IP set!</p>";
      }else{
        $ip = htmlspecialchars($_POST['server']);
        echo "<p><strong>Server IP:</strong> ".$ip.".</p>";
        $json = file_get_contents('https://api.mcsrvstat.us/1/'.$ip);
        $obj = json_decode($json);

        $numberip = htmlspecialchars($obj->ip);

        if(empty(numberip) OR $obj->offline) {
          echo "<p>No valid IP or server offline!</p>";
          return;
        }

        $port = htmlspecialchars($obj->port);
        $version = htmlspecialchars($obj->version);
        $verSoftware = htmlspecialchars($obj->software);
        $mapname = htmlspecialchars($obj->map);
        $icon = $obj->icon;

        if (!empty($icon)) {
          echo '<link rel="icon" href="'.$icon.'">';
        }

        echo "<p><strong>Direct IP:</strong> ".$numberip.":".$port."</p>";
        echo "<p><strong>Version:</strong> ".$version." (".$verSoftware.")</p>";
        if (!empty($mapname)) {
          echo "<p><strong>Map:</strong> ".$mapname."</p>";
        }

        echo "<p><strong>Direct IP:</strong> ".$numberip.":".$port."</p>";
        echo "<p><strong>Version:</strong> ".$version." (".$verSoftware.")</p>";

        foreach ($obj->players->list as $player) {
	         $players = $players.htmlspecialchars($player).', ';
         }

         $online = htmlspecialchars($obj->players->online);
         $max = htmlspecialchars($obj->players->max);
         if (empty($players)) {
            echo "<p><strong>Players:</strong> ".$online."/".$max."</p>";
         }else{
            #Remove last 2 characters ', ' from string
            $players = substr($players, 0, -2);
            echo "<p><strong>Players:</strong> " . $players." (" . $online."/" .$max.")</p>";
        }

        foreach ($obj->plugins->raw as $plugin) {
	         $plugins = $plugins.htmlspecialchars($plugin).', ';
         }

         if (empty($plugins)) {
             echo "<p><strong>Plugins:</strong> Hidden.</p>";
         }else{
           #Remove last 2 characters ', ' from string
           $plugins = substr($plugins, 0, -2);
           echo "<p><strong>Plugins:</strong> ".$plugins."</p>";
        }
      }
    }
?>
