<?php include('aurora-lib.php'); ?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Miners Haven</title>
      <link href="./css/minecraft.css" media="all" rel="Stylesheet" type="text/css" />
      <!-- JavaScript is the default scripting language in HTML5 and in all modern browsers -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/minecraft.js"></script>
</head>

<body>
    <header>
        <ul id="header-list">
            <li><a href="./index.php">Home Portal</a></li>
            <li><a href="./administration.php">Administration</a></li>
        </ul>
        
    </header>
    
    <ul id="sidebar">
        <li class="content-element"><a class="content-element-link" href="readme.php">README</a></li>
    </ul>
        
    <div id="subject">- Configure -</div>
    <div id="content">
        <?php
            $server = sqlConnect('localhost','minecraftserver','root','');
                        
            if(isset($_POST['maximum'])) 
            {
                setServerSetting($server, 'startup', 'maxmem', $_POST['maximum']);
            }
            if(isset($_POST['minimum'])) 
            {
                setServerSetting($server, 'startup', 'minmem', $_POST['minimum']);
            }
            
            if(isset($_POST['gui']))
            {
                setServerSetting($server, 'startup', 'nogui', 1);
            }
            else
            {
                if(isset($_POST['minimum']) or isset($_POST['maximum']))
                {
                    setServerSetting($server, 'startup', 'nogui', 0);
                }
            }
            
            $rules = $_POST['rules'];
            
            $maxMem = getServerSetting($server, 'startup', 'maxmem');
            $minMem = getServerSetting($server, 'startup', 'minmem');
            $nogui = getServerSetting($server, 'startup', 'nogui');
            
            if($nogui)
            {
                $nogui = 'True';
            }
            else
            {
                $nogui = 'False';
            }
            
            $directory = getServerSetting($server, 'mcinstall', 'installPath');
            $version = getServerSetting($server, 'mcinstall', 'installVersion');
            $serviceName = getServerSetting($server, 'mcinstall', 'serviceName');
            
            $startup = "java -Xmx" . $maxMem . " -Xms" . $minMem . " -jar " . $directory . "minecraft_server." . $version . ".jar";
            if($nogui == 'True')
            {
                $startup = $startup . " nogui";
            }
            file_put_contents($directory . "startserver.bat", 'cd ' . $directory . "\n");
            file_put_contents($directory . "startserver.bat", $startup, FILE_APPEND);
            file_put_contents($directory . "server.properties", $rules);
            
            file_put_contents($directory . "eula.txt", "eula=true");
            
            $currentStartup = file_get_contents($directory . "startserver.bat");
        ?>
            New startup configuration:<br>
            <em><?=$currentStartup;?></em>
            
            <p>
            
            <ul><li class="content-element"><a class="content-element-link" href="boot.php">Boot Server</a></li></ul>
        
        
    </div>
    <footer>
    </footer>
</body>
</html>