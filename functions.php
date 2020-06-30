<?php 

function readDocument($filename){
    $fh = fopen('imports/'.$filename,'r');
    return $fh;
}

function createHost_MultipleInterface($hostname, $ip, $groupid){
    $json = array( 
        "jsonrpc"=>"2.0",
        "method"=> "host.create",
        "params" => array(
            "host" => $hostname, 
            "interfaces" => array(   
                array(
                    "type" => 1,
                    "main" => 1,
                    "useip" => 1,
                    "ip" => $ip,
                    "dns" => "",
                    "port" => "10050"
                ),
                array(
                    "type" => 2,
                    "main" => 1,
                    "useip" => 1,
                    "ip" => $ip,
                    "dns" => "",
                    "port" => "161",
                    "details" => array(
                        "version"=> "2",
                        "bulk" => "1",
                        "community" => '{$SNMP_COMMUNITY}'
                    )
                )
            ),
            "groups" => array(
                array(
                    "groupid"=> $groupid
                )          
            ),
        ),
        "id"=> 1,
        "auth"=>"27702d89993d3deb644e0c32598a9bfa"
    );
    return $json;
}
function post_HostCreate($json){
    //Se inicializa la variable $peticion con la ip.
    //Posterior se establecen los metodos: POST.
    //Se establecen lo headers.
    $peticion = curl_init('http://10.21.211.105/zabbix/api_jsonrpc.php');                                                                      
    curl_setopt($peticion, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($peticion, CURLOPT_POSTFIELDS, $json);                                                                  
    curl_setopt($peticion, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($peticion, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($json))                                                                       
    );                                                                                                                   
    //Se ejecuta el curl de la peticion y se guarda la respuesta del servidor 
    //en la variable response que es retornada por la funcion Post_HostCreate                                                                                                                   
    $response = curl_exec($peticion);
    return json_decode($response, true);
}
function createHost_MI_ISerialnum($hostname, $ip, $groupid, $I_serialna, $I_type,$I_software, $I_name, $I_model, $I_maca){
    $json = array( 
        "jsonrpc"=>"2.0",
        "method"=> "host.create",
        "params" => array(
            "host" => $hostname, 
            "interfaces" => array(   
                array(
                    "type" => 1,
                    "main" => 1,
                    "useip" => 1,
                    "ip" => $ip,
                    "dns" => "",
                    "port" => "10050"
                ),
                array(
                    "type" => 2,
                    "main" => 1,
                    "useip" => 1,
                    "ip" => $ip,
                    "dns" => "",
                    "port" => "161",
                    "details" => array(
                        "version"=> "2",
                        "bulk" => "1",
                        "community" => '{$SNMP_COMMUNITY}'
                    )
                )
            ),
            "groups" => array(
                array(
                    "groupid"=> $groupid
                )          
            ),
            "inventory_mode"=>0,
            "inventory"=> array(
                "serialno_a"=>$I_serialna,
                "name"=>$I_name,
                "macaddress_a"=>$I_maca,
                "type"=>$I_type,
                "software"=>$I_software,
                "model"=>$I_model,

            )
        ),
        "id"=> 1,
        "auth"=>"27702d89993d3deb644e0c32598a9bfa"
    );
    return $json;
}

?>
