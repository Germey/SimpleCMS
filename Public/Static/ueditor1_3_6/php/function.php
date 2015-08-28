<?php

    function getServerRootPath()  {
        $fullPath = str_replace('\\','/',dirname(__FILE__));
        return substr($fullPath, 0, strpos($fullPath, 'thinkphp')) .  base64_decode(htmlspecialchars($_GET['projectname'])) . '/' ;
    }

?>