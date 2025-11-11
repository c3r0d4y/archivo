function refresh(label,time,url,v1,v2)
{
    console.log(v2);
   
    var cont = time;
    // define our vars
    var label,time,url,fetch_unix_timestamp;
    // Chequeamos que las variables no esten vacias..
    if(label == ""){alert('El id de la etiqueta no se ha definido'); return;}
    else if(!document.getElementById(label)){ alert('Error: el Div ID selectionado no esta definido: '+label); return;}
    else if(time == ""){ alert('Error: indica la cantidad de segundos que quieres que el div se refresque'); return;}
    else if(url == ""){ alert('La url o funcion n esta disponible'); return;}

    if(v1!="" & v2!=""){
        var v11=document.getElementById(v1).value;
        var v22=document.getElementById(v2).value;
    }
    // The XMLHttpRequest object
    var xmlHttp;
    try{
        xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
    }
    catch (e){
        try{
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
        }
        catch (e){
            try{
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e){
                alert("Tu explorador no soporta AJAX.");
                return false;
            }
        }
    }

    // Timestamp para evitar que se cachee el array GET
    fetch_unix_timestamp = function()
    {
        return parseInt(new Date().getTime().toString().substring(0, 10))
    }

    var timestamp = fetch_unix_timestamp();
    var urlVariables = url+"?t="+timestamp+"&v1="+v11+"&v2="+v22;
    
    // the ajax call
    
    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            document.getElementById(label).innerHTML=xmlHttp.responseText;
            
            setTimeout(function(){refresh(label,time,url,v1,v2);},time*1000);
            
            $.ajax({
                type: "POST",
                url: url,
                success: function(response)
                {	
                    $(label).html(response);
                    console.log("...");
                }
            });		
                
        }
    }
     
    xmlHttp.open("GET",urlVariables);
    xmlHttp.send();
    
}