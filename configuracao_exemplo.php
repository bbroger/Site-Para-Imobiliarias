<?php

    $token = "PARA REALIZAR O LOGIN NO SERVIÇO REST";
    $api_js_google = "EXEMPLO: AIzaSyCU5i4000RcqhP0011UhkjhUYGkjhmjuj";
    $api = "http://rest.com.br/api";
    $imobiliaria_title = "Imóveis e Administração - Cidade";
    $imobiliaria_nome = "Imobiliária Imóveis";
    $imobiliaria_creci = "00.000J";
    $imobiliaria_endereco = "Rua XXXXX, 123 Cidade-SP";
    $imobiliaria_telefone = "(00) 0000-0000";
    $imobiliaria_site = "http://www.dominio.com.br/site";
    $imobiliaria_email = "contato@dominio.com.br";
    $imobiliaria_facebook = "https://www.facebook.com/fanpage/";
    $imobiliaria_youtube = "https://www.youtube.com/channel/canal";
    $imobiliaria_android = "https://www.androidmarket.com/download/";
    $imobiliaria_logo_pequeno = "img/foto_logo_pequeno.png";
    $imobiliaria_logo_grande = "img/foto_logo_grande.png";
    $imobiliaria_logo_facebook = $imobiliaria_site."/img/foto_logo_facebook.jpg";
    $imobiliaria_logo_favicon = "img/foto_logo_pequeno.png";
    $imobiliaria_cor = "vermelho"; # amarelo, azul, laranja, verde, vermelho
    $imobiliaria_chaves = "Para o Google encontrar o site...";
    $imobiliaria_descricao = "Para sair na descrição do Facebook...";
    $imobiliaria_quemsomos = "Para sair no Quem Somos...";

    $imobiliaria_corretores = array(
                            ['NOME'=>'João das Couves', 
                                'EMAIL'=>'joao@dominio.com.br', 
                                'TELEFONE'=>'(00) 0000-0000', 
                                'WHATSAPP'=>'(00) 0000-0000',
                                'FOTO'=>'foto_joao.jpg'],
                            ['NOME'=>'Maria das Graças', 
                                'EMAIL'=>'maria@tendaimoveis.com.br', 
                                'TELEFONE'=>'(00) 0000-0000', 
                                'WHATSAPP'=>'(00) 0000-0000',
                                'FOTO'=>'foto_maria.jpg'],
                            );

    $imobiliaria_empreendimentos = array(
                            ['NOME'=>'Veredas de Franca', 
                                'IMAGEM'=>'img/foto_empreendimento_veredas.jpg', 
                                'LINK'=>'https://www.facebook.com/linkPost'], 
                            ['NOME'=>'Unique Residencial', 
                                'IMAGEM'=>'img/foto_empreendimento_unique.jpg', 
                                'LINK'=>'https://www.facebook.com/linkPost'], 
                            ['NOME'=>'Loteamento Santa Bárbara', 
                                'IMAGEM'=>'img/foto_empreendimento_barbara.png', 
                                'LINK'=>'https://www.facebook.com/linkPost'],
                            ['NOME'=>'Loteamento Quinta do Oeste', 
                                'IMAGEM'=>'img/foto_empreendimento_quinta.jpg', 
                                'LINK'=>'https://www.facebook.com/linkPost'],
                            ['NOME'=>'Loteamento Santa Georgina', 
                                'IMAGEM'=>'img/foto_empreendimento_georgina.jpg', 
                                'LINK'=>'https://www.facebook.com/linkPost'],
                            );


    $imovel_tipos = array("Locação", "Venda"); # Ou Temporada
    $imovel_valores = array(
                            "0-300"=>"até 300", 
                            "300-400"=>"de 300 até 400",
                            "400-500"=>"de 400 até 500",
                            "500-750"=>"de 500 até 750",
                            "750-1000"=>"de 750 até 1.000 mil",
                            "1000-1250"=>"de 1.000 mil até 1.250 mil",
                            "1250-1500"=>"de 1.250 mil até 1.500 mil",
                            "1500-2000"=>"de 1.500 mil até 2.000 mil",
                            "2000-3000"=>"de 2.000 mil até 3.000 mil",
                            "3000-5000"=>"de 3.000 mil até 5.000 mil",
                            "5000-7500"=>"de 5.000 mil até 7.500 mil",
                            "7500-10000"=>"de 7.500 mil até 10.000 mil",
                            "10000-20000"=>"de 10.000 mil até 20.000 mil",
                            "20000-60000"=>"de 20.000 mil até 60.000 mil",
                            "60000-100000"=>"de 60.000 mil até 100.000 mil",
                            "100000-150000"=>"de 100.000 mil até 150.000 mil",
                            "150000-200000"=>"de 150.000 mil até 200.000 mil",
                            "200000-250000"=>"de 200.000 mil até 250.000 mil",
                            "250000-300000"=>"de 250.000 mil até 300.000 mil",
                            "300000-500000"=>"de 300.000 mil até 500.000 mil",
                            "500000-0"=>"mais de 500.000 mil",
                            );

?>