<?php

    function recuperaArray($recebimento_api){
        if($recebimento_api->info->http_code == 200)
            return $recebimento_api->decode_response();
        else
            return array();
    }

    function formataDinheiro($valor){
        if ( empty($valor) )
            $valor = 0; 

        setlocale(LC_MONETARY, 'pt_BR');
        return money_format('%.2n', $valor);
    }

    function getFotoFachada($id_imovel){
        global $token, $api;

        if ( empty($id_imovel) )
            $id_imovel = 0; 

        $imoveisFotos = $api->get("fotos", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FACHADA,eq,1', 'FOTO,cs,_60_', 'ID_IMOVEL,eq,'.$id_imovel),
                'page'=>'1,1',
                'order[]'=>'FOTO,asc',
                ]);
        $imoveisFotos = recuperaArray($imoveisFotos);

        if ( empty($imoveisFotos->fotos[0]->FOTO) ){ 
            return 'img_coringa.jpg';
        } else {
            return strtoupper($imoveisFotos->fotos[0]->FOTO);
        } 
    }

    function enviaEmail($de, $assunto, $mensagem, $para, $email_servidor) {
        $headers = "From: $email_servidor\r\n" .
                    "Reply-To: $de\r\n" .
                    "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($para, $assunto, nl2br($mensagem), $headers);
    }

    function trataString($string = ""){
        // REMOVER NOMES DE QUADRANTES DOS BAIRROS
        $string = str_replace("[Q0]", "", $string);
        $string = str_replace("[Q1]", "", $string);
        $string = str_replace("[Q2]", "", $string);
        $string = str_replace("[Q3]", "", $string);
        $string = str_replace("[Q4]", "", $string);
        $string = str_replace("[Q5]", "", $string);

        return trim(addslashes(strip_tags($string)));
    }

    function pegaEndereco($endereco = ""){ // Formato do banco: RUA DOUTOR LUIZ COELHO CEP: 14403525
        return trataString(preg_replace('/( CEP: (\d+))/','', $endereco));
    }

    function pegaCep($endereco = ""){ // Formato do banco: RUA DOUTOR LUIZ COELHO CEP: 14403525
        preg_match('/( CEP: (\d+))/', $endereco, $ceps);

        if(  preg_match('/(\d{5})(\d{3})/', trim($ceps[2]), $cep ) ){
            return $cep[1] .'-'. $cep[2];
        } else {
            return '14400-000';
        }
    }

?>