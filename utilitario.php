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
            return $imoveisFotos->fotos[0]->FOTO;
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
        return trim(addslashes(strip_tags($string)));
    }

?>