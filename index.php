<?php
    $rede = "192.168.0."; # - Uma casa do IP, não digitar ex: 192.168.0.
    $inicio = "2";        # - Início no IP 1
    $fim = "10";          # - Termina no IP 255
    $iplista = array(); 
    $resultados = [];

    # - Verificar IP´s
    for ($i=$inicio; $i<=$fim; $i++) {
        $aux_rede = $rede.$i;
        $ping = exec("ping -n 1 -w 1 $aux_rede", $output, $retval);

        # - Verificar Hostname
        if ($retval == 0){
            $output2 = '';
            $hostname = exec("ping -a -w 1 $aux_rede", $output2, $retval2);
            if ($retval2 == 0){
                //echo var_dump($output2).'<br/><br/>';
                $partes = explode(' ', $output2[1]);
                array_push($iplista, array($aux_rede, $partes[1]));
            }
            else{
                array_push($iplista, array($aux_rede, "TESTE_REDE_".$i));
            }
        }else{
            array_push($iplista, array($aux_rede, "TESTE_REDE_".$i));
        }
        $resultados[] = $retval;
    }
?>