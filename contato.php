<?php

    require "configuracao.php";
    require "utilitario.php"; 

    if ( empty($_POST['link']) )
        die('NAO PODE!');

    enviaEmail(
        trataString($_POST['email']), 
        trataString('CONTATO DE CLIENTE').' '. strtoupper(trataString($_POST['nome'])), 
        '<b>FAVOR RESPONDER AO CLIENTE (VERIFIQUE O ENDEREÇO DE EMAIL)</b><br>
        LINK: '.$_POST['link'].'<br/><br/>CLIENTE: '.trataString($_POST['nome']).'<br/><br/>
        TELEFONE: '.trataString($_POST['telefone']).'<br/><br/>MENSAGEM: '.trataString($_POST['texto']), 
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