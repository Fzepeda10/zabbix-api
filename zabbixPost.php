<?php
require 'functions.php';
$input = readline("Nombre del archivo: ");
$modo = readline("¿Cargar Inventario? [s/n]: ");
if($modo=="s"){
    $fh = readDocument($input);
    $cont = 0;
    $i=1;
    while ($line = fgets($fh)) {
        $hostparams = explode('|',$line);  
        $json = createHost_MI_ISerialnum($hostparams[0], $hostparams[1], $hostparams[2],$hostparams[3],
    $hostparams[4],$hostparams[5],$hostparams[6],$hostparams[7], $hostparams[8]);
        $x = post_HostCreate(json_encode($json));    
        if(key_exists("error", $x)){
            echo "Zabbix Server: ".$x['error']['data']."| Linea de error: $i"."\n";
        }else{
            echo "Zabbix Server: Host ".$x['result']['hostids'][0]." creado.\n";
            $cont ++;
        }
        $i++;
    }
}else{
    $fh = readDocument($input);
    $cont = 0;
    while ($line = fgets($fh)) {
        $hostparams = explode('|',$line);  
        $json = createHost_MultipleInterface($hostparams[0], $hostparams[1], $hostparams[2]);
        $x = post_HostCreate(json_encode($json));    
        if(key_exists("error", $x)){
            echo "Zabbix Server: ".$x['error']['data']."\n";
        }else{
            echo "Zabbix Server: Host ".$x['result']['hostids'][0]." creado.\n";
            $cont ++;
        }
        
    }
}
echo "\n"."Cantidad de registros subidos al servidor: ".$cont;
fclose($fh);
?>