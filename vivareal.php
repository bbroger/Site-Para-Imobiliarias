<?php
header('Content-type: text/xml');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 0);
ini_set('memory_limit','3000M');
ini_set('post_max_size','2000M');

require "arquivo_c.php";
require "utilitario.php"; 
require "restclient.php"; 

$api = new RestClient(['base_url' => $api]);

$imoveis = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter'=> array('ANUNCIO,eq,SIM') 
                ]); // 'FINALIDADE,eq,ALUGUEL' 'order[]'=>'ID_IMOVEL,desc',  'page'=>'1,10'
$imoveis = recuperaArray($imoveis);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<ListingDataFeed xmlns="http://www.vivareal.com/schemas/1.0/VRSync" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://www.vivareal.com/schemas/1.0/VRSync  http://xml.vivareal.com/vrsync.xsd">
    <Header>
        <Provider><?= $imobiliaria_title ?></Provider>
        <Email><?= $imobiliaria_email ?></Email>
    </Header>
    <Listings>
        <?php foreach($imoveis->imovel as $imovel){?>
        <Listing>
        <ListingID><?= $imovel->COD_IMOVEL ?></ListingID>
        <Title><![CDATA[<?= $imovel->TIPO, ' PARA '. $imovel->FINALIDADE .' '. $imovel->BAIRRO .'. - '. $imovel->ESTADO ?>Apartamento PARA Venda Moema. - São Paulo / SP]]></Title>
        <?php
            if ($imovel->FINALIDADE == 'VENDA')
                $finalidade = 'For Sale';
            elseif ($imovel->FINALIDADE == 'ALUGUEL')
                $finalidade = 'For Rent';
            else
                $finalidade = 'Sale/Rent';       
        ?>
        <TransactionType><?= $finalidade ?></TransactionType>
        <Media>
            <Item medium="image" caption="Fachada" primary="true"><?= str_replace('/bem-vindo','',$imobiliaria_site) .'/fotos_imoveis/'. getFotoFachada($imovel->ID_IMOVEL) ?></Item>
            <?php 
                $fotos = $api->get("fotos", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FOTO,ncs,_60_', 'COD_IMOVEL,eq,'. $imovel->COD_IMOVEL ), 
                'order[]'=>'foto,asc',
                ]);
                $fotos = recuperaArray($fotos);
                
                foreach($fotos->fotos as $foto){ 
            ?>
            <Item medium="image" caption="<?= $foto->DESCRICAO ?>"><?= str_replace('/bem-vindo','',$imobiliaria_site) .'/fotos_imoveis/'. strtoupper($foto->FOTO) ?></Item>
            <?php } ?>
        </Media> 
        <Details>
            <?php

                if ($imovel->AREA_TERRENO <= 0)
                    $areaNumeroGerado = rand(200,250);
                else
                    $areaNumeroGerado = $imovel->AREA_TERRENO;

                $tipo = 'Residential / Home';
                $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';

                switch ( trim(strtoupper($imovel->TIPO)) ) {
                    case "APARTAMENTO":
                        $tipo = 'Residential / Apartment';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "RESIDENCIA":
                        $tipo = 'Residential / Home';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "CHÁCARA":
                        $tipo = 'Residential / Farm Ranch';
                        $area = '<LotArea unit="square metres">'. $areaNumeroGerado .'</LotArea>';
                        break;
                    case "CONDOMÍNIO":
                        $tipo = 'Residential / Condo';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "FLAT":
                        $tipo = 'Residential / Flat';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "LOTEAMENTO":
                        $tipo = 'Residential / Land Lot';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "SOBRADO":
                        $tipo = 'Residential / Sobrado';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "COBERTURA":
                        $tipo = 'Residential / Penthouse';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "KITNET":
                        $tipo = 'Residential / Kitnet';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "CONSULTÓRIO":
                        $tipo = 'Commercial / Consultorio';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "SALA COMERCIAL":
                        $tipo = 'Commercial / Office';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "FAZENDA":
                        $tipo = 'Commercial / Agricultural';
                        $area = '<LotArea unit="square metres">'. $areaNumeroGerado .'</LotArea>';
                        break;
                    case "GALPÃO":
                        $tipo = 'Commercial / Industrial';
                        $area = '<LotArea unit="square metres">'. $areaNumeroGerado .'</LotArea>';
                        break;
                    case "COMERCIAL":
                        $tipo = 'Commercial / Building';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "LOJA":
                        $tipo = 'Commercial / Loja';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "TERRENO":
                        $tipo = 'Commercial / Land Lot';
                        $area = '<LotArea unit="square metres">'. $areaNumeroGerado .'</LotArea>';
                        break;
                    case "SALA/CONJUNTO":
                        $tipo = 'Commercial / Business';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                    case "EDIFÍCIO":
                        $tipo = 'Commercial / Residential Income';
                        $area = '<LivingArea unit="square metres">'. $areaNumeroGerado .'</LivingArea>';
                        break;
                }
            ?>
            <PropertyType><?= $tipo ?></PropertyType>
            <Description><![CDATA[<?= trim($imovel->DESCRICAO .' Código: '.$imovel->COD_IMOVEL) ?>]]></Description>

            <?php
                $valor = str_replace(',','',number_format($imovel->VALOR));
                if ($imovel->FINALIDADE == 'VENDA'){
                    echo '<ListPrice currency="BRL">'. $valor .'</ListPrice>';
                } elseif ($imovel->FINALIDADE == 'ALUGUEL') {
                    echo '<RentalPrice currency="BRL" period="Monthly">'. $valor .'</RentalPrice>';
                } else {
                    echo '<ListPrice currency="BRL">'. $valor .'</ListPrice>';
                    echo '<RentalPrice currency="BRL" period="Monthly">'. $valor .'</RentalPrice>';
                }
                            
            ?>
            <?= $area ?>
            <Bedrooms><?= $imovel->DORMITORIOS ?></Bedrooms>
            <Bathrooms><?= $imovel->BANHEIROS ?></Bathrooms>
        </Details>
        <Location displayAddress="Street">
            <Country abbreviation="BR">Brasil</Country>
            <State abbreviation="<?= $imovel->ESTADO ?>">São Paulo</State>
            <City><?= $imovel->CIDADE ?></City>
            <Neighborhood><?= trataString($imovel->BAIRRO) ?></Neighborhood>
            <Address><?= pegaEndereco($imovel->ENDERECO) ?></Address> 
            <StreetNumber><?= $imovel->NUMERO ?></StreetNumber> 
            <PostalCode><?= pegaCep($imovel->ENDERECO) ?></PostalCode>
        </Location>
        <ContactInfo>
            <Name><?= $imobiliaria_nome ?></Name>
            <Email><?= $imobiliaria_email ?></Email>
         </ContactInfo>
        </Listing>
        <?php } ?>
    </Listings>
</ListingDataFeed>