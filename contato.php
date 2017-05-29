<?php

    require "configuracao.php";
    require "utilitario.php"; 

    if ( empty($_POST['link']) )
        die('NAO PODE!');

    enviaEmail(
        trataString($_POST['email']), 
        trataString('CONTATO CLIENTE').' '. strtoupper(trataString($_POST['nome'])), 
        '<b>FAVOR RESPONDER AO CLIENTE (VERIFIQUE O ENDEREÇO DE EMAIL)</b><br>
        LINK: '.$_POST['link'].'<br/><br/>CLIENTE: '.trataString($_POST['nome']).'<br/>EMAIL: '.trataString($_POST['email']).'<br/>
        TELEFONE: '.trataString($_POST['telefone']).'<br/><br/>MENSAGEM: <b>'.trataString($_POST['texto']).'</b>', 
        trataString('edsonlb@gmail.com'), 
        trataString($imobiliaria_email));

    header('Location: '.$_POST['link']);
/*
    enviaEmail(
        trataString($_POST['email']), 
        trataString('CONTATO DE CLIENTE'), 
        trataString($_POST['texto']), 
        trataString($_POST['para']), 
        trataString($imobiliaria_email));
        */

?>