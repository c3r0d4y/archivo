<?php

     function v($datos, $tipo, $parametro){
        if($tipo == "password"){
            if(strlen($datos) < 15){
                return('x');
            }
        }
        elseif($tipo == "passwordN"){
            if($datos!="" && strlen($datos) < 15){
                return(123456);
            }
        }
        elseif($tipo == "cadena"){
            if($parametro=='encode'){
                $datos=htmlentities($datos);
                $datos=htmlspecialchars($datos, ENT_QUOTES);
            }elseif($parametro=='decode'){
                $datos=htmlspecialchars_decode($datos);
                $datos=html_entity_decode($datos); 
            }
        }   
        elseif($tipo == "foto"){
            if(isset($datos)){
                //echo "Entra a archivo<br/>";
                //nombre Temporal         
                $fileName = $datos['name'];
                //echo "nombre:".$fileName."<br/>";
                
                //Validamos el tamaño en bytes 1 MB=1,000,000
                $fileSize = $datos['size'];
                //echo "Tamaño:".$fileSize;
                if($fileSize>1000000){
                    return('size');
                }
                //extraemos extencion
                $nameArray = explode(".", $fileName);
                //Convertimos a minusculas
                $extencion = strtolower(end($nameArray));
                //echo "extencion:".$extencion."<br/>";
                if($extencion !="png" && $extencion !="jpg" && $extencion !="jpeg" && $fileName!=""){
                    //echo "Entra a null<br/>";
                    return('formato');
                }
            }else{
                return(3);
            } 
        }
        //todo tipo de archivos
        elseif($tipo == "archivos" && 'todos'){
            //echo "Entra a f<br/>";
            if(isset($datos)){
                //echo "Entra a archivo<br/>";
                //nombre Temporal         
                $fileName = $datos['name'];
                //echo "nombre:".$fileName."<br/>";
                //Tamaño
                $fileSize = $datos['size'];
                if($fileSize>50000000){
                    return('size');
                }
                //extraemos extencion
                $nameArray = explode(".", $fileName);
                //Convertimos a minusculas
                $extencion = strtolower(end($nameArray));
                if($extencion !="pdf" && $extencion !="html" && $extencion !="png" && $extencion !="jpg" && $extencion !="html" &&
                $extencion !="jpeg" && $fileName!="" && $extencion!="txt" && $extencion!="aab" && $extencion!="ipa" &&
                $extencion!="apk" && $extencion!="zip" && $extencion!="rar" && $extencion!="docx" && $extencion!="pptx" && $extencion!="mp4"){
                    //echo "Entra a null<br/>";
                    return('formato');
                }
            }
        }
        //documentos pdf
        elseif($tipo == "documento" && $parametro=="pdf"){
            if(isset($datos) && $datos['name']!=""){
                echo "Si se carga un archivo el archivo<br/>";
                //nombre Temporal         
                $fileName = $datos['name'];
                //echo "nombre:".$fileName."<br/>";
                
                //Validamos el tamaño en bytes 1 MB=1,000,000
                $fileSize = $datos['size'];
                //echo "Tamaño:".$fileSize;
                if($fileSize>30000000){
                    return('size');
                }
                //extraemos extencion
                $nameArray = explode(".", $fileName);
                //Convertimos a minusculas
                $extencion = strtolower(end($nameArray));
              
                if($extencion !="pdf"){
                    //echo "Entra a null<br/>";
                    return('formato');
                }
            }else{
                return(3);
            } 
        }
        //videos
        elseif($tipo == "v"){
            //echo "Entra a f<br/>";
            if(isset($datos)){
                //echo "Entra a archivo<br/>";
                //nombre Temporal         
                $fileName = $datos['name'];
                //echo "nombre:".$fileName."<br/>";
                //Tamaño
                $fileSize = $datos['size'];
                if($fileSize>3000000){
                    return('size');
                }
                //extraemos extencion
                $nameArray = explode(".", $fileName);
                //Convertimos a minusculas
                $extencion = strtolower(end($nameArray));
                //echo "extencion:".$extencion."<br/>";
                if($extencion !="mp4" && $extencion !="avi" &&  $fileName!=""){
                    //echo "Entra a null<br/>";
                    return(null);
                }
            }
        }
        //archivos comprimidos
        elseif($tipo == "aarchivo" &&  $parametro=="ziprar"){
            if(isset($datos)){       
                $fileName = $datos['name'];
                //Tamaño
                $fileSize = $datos['size'];
                if($fileSize>3000000){
                    return('size');
                }
                $nameArray = explode(".", $fileName);
                $extencion = strtolower(end($nameArray));
                if($extencion !="zip" && $extencion !="rar" && $fileName!=""){
                    //echo "Entra a null<br/>";
                    return("formato");
                }
            }
        }
        return($datos);   
    }
     
?>