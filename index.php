<?php
    $rede = "192.168.0."; # - Não digitar a ultima faixa do IP, ex: 192.168.0.
    $inicio = "2";        # - Início do IP, ex: 1
    $fim = "10";          # - Termino do IP, ex: 255
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

    # - Gerar tabela
    echo "<table border = 1>
    <tr>
        <td>#</td>
        <td>Descrição</td>
        <td>IP/URL</td>
        <td>Status</td>
    </tr>";
    
    foreach($resultados as $item => $itens){
        echo '<tr>';
        echo '<td>'.$item.'</td>';
        echo '<td>'.$iplista[$item][1].'</td>';
        echo '<td>'.$iplista[$item][0].'</td>';
        if ($resultados[$item] == 0){
            echo '<td style=color:green><br/>On-line</td>';
        }else{
            echo '<td style=color:red><br/>Off-line</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo header('refresh: 4');
?>