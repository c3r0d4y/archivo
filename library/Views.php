<?php
//Archivo para renderisar las vistas
 class Views
 {
    
     function render($controller, $view, $menu, $param){
        $controller = get_class($controller);
        //echo 'Vista r='.$view.'Menu='.$menu.'<br/>';
        if($menu==""){
            require VIEWS.DFT."/head_v.php";
        }else{
            require VIEWS.DFT."/head0_v.php";
        }
        require VIEWS.$controller.'/'.$view.'.php';
        require VIEWS.DFT."/footer_v.php";
        
     }
     
 }
 

?>