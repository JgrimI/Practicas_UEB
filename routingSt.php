<?php 
	if(isset($_GET['menu'])){
        switch($_GET['menu']){
            case 'stats':
                include_once('ModuleStudent/listStats.php');
            break;
            case 'vacants':
                include_once('ModuleStudent/listVacants.php');
            break;
            default:
                include_once('ModuleStudent/listStats.php');
            break;

        }
    }else{
        include_once('ModuleStudent/listStats.php');
    }
?>