<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
ini_set('display_errors', 1);

require "configuracao.php";
require "utilitario.php"; 
require "restclient.php"; 

$api = new RestClient(['base_url' => $api]);

$bairrosQtde = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'BAIRROSQTDE']);
$bairrosQtde = recuperaArray($bairrosQtde);

$modelosQtde = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'MODELOSQTDE']);
$modelosQtde = recuperaArray($modelosQtde);

if ( empty($_REQUEST['codigo']) )
  $codigo = 0;
else
  $codigo = $_REQUEST['codigo'];

$imovel = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter[]'=> 'COD_IMOVEL,eq,'.$codigo,
                'page'=>'1,1',
                ]);

$imovel = recuperaArray($imovel);
$imovel = $imovel->imovel[0];

shuffle($imobiliaria_corretores);
array_rand($imobiliaria_corretores);
?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="description" content="<?= $imovel->DESCRICAO ?>">
    <meta name="keywords" content="Imóvel, <?= $imobiliaria_chaves ?>" />
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="IMÓVEL NO BAIRRO <?= $imovel->BAIRRO .' ('. $imovel->CIDADE .') '. formataDinheiro($imovel->VALOR) ?>" />
    <meta property="og:description" content="<?= $imovel->DESCRICAO ?>" />
    <meta property="og:image" content="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; ?>/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>" />
    <meta property="fb:app_id" content="1496712770565168"/>
    <!-- <meta name="author" content="Celula Digital Software"> -->
    <meta property="article:author" content="<?= $imobiliaria_site ?>"/>
    <link rel="shortcut icon" href="<?= $imobiliaria_logo_favicon ?>">

    <title>Imóvel - <?= $imovel->BAIRRO.' - '.$imovel->ENDERECO ?></title>

    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,800' rel='stylesheet' type='text/css'>
    <script src="https://use.fontawesome.com/5b95069487.js"></script>
    <link href="cor_<?= $imobiliaria_cor ?>/css/style.css" rel="stylesheet">
    <link href="cor_<?= $imobiliaria_cor ?>/css/responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="top">

<?php include 'topo.php'; ?>

    <!-- begin:content -->
    <div id="content">
      <div class="container">
        <div class="row">
          <!-- begin:article -->
          <div class="col-md-9 col-md-push-3">
            <div class="row">
              <div class="col-md-12 single-post">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                  <li class="active"><a href="#detail" data-toggle="tab"><i class="fa fa-university"></i> Detalhes do Imóvel</a></li>
                  <li><a href="#location" data-toggle="tab"><i class="fa fa-paper-plane-o"></i> Mapa & Contato</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade in active" id="detail">
                    <div class="row">
                      <div class="col-md-12">
                        <h2><?= $imovel->BAIRRO ?></h2>
                        <div id="slider-property" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                            <li data-target="#slider-property" data-slide-to="0" class="">
                              <img src="img/img02.jpg" alt="">
                            </li>
                            <li data-target="#slider-property" data-slide-to="1" class="active">
                              <img src="img/img03.jpg" alt="">
                            </li>
                            <li data-target="#slider-property" data-slide-to="2">
                              <img src="img/img04.jpg" alt="">
                            </li>
                          </ol>
                          <div class="carousel-inner">
                            <div class="item">
                              <img src="img/img02.jpg" alt="">
                            </div>
                            <div class="item active">
                              <img src="img/img03.jpg" alt="">
                            </div>
                            <div class="item">
                              <img src="img/img04.jpg" alt="">
                            </div>
                          </div>
                          <a class="left carousel-control" href="#slider-property" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                          </a>
                          <a class="right carousel-control" href="#slider-property" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                          </a>
                        </div>
                        <h3>Detalhes</h3>
                        <table class="table table-bordered">
                          <tr>
                            <td width="20%"><strong>Código</strong></td>
                            <td><?= $imovel->COD_IMOVEL ?></td>
                          </tr>
                          <tr>
                            <td><strong>Valor</strong></td>
                            <td><?= formataDinheiro($imovel->VALOR) ?></td>
                          </tr>
                          <tr>
                            <td><strong>Tipo</strong></td>
                            <td><?= $imovel->FINALIDADE .' / '. $imovel->TIPO ?></td>
                          </tr>
                          <tr>
                            <td><strong>Endereço</strong></td>
                            <td><?= $imovel->ENDERECO .', '. $imovel->BAIRRO .', '. $imovel->CIDADE .'-'. $imovel->ESTADO ?></td>
                          </tr>
                          <tr>
                            <td><strong>Área</strong></td>
                            <td><?= ' Terreno ('. $imovel->AREA_TERRENO .'m<sup>2</sup>) & Construção ('. $imovel->AREA_CONSTRUIDA .'m<sup>2</sup>)' ?></td>
                          </tr>
                          <tr>
                            <td><strong>Garagem</strong></td>
                            <td><?= $imovel->GARAGEM ?></td>
                          </tr>
                          <tr>
                            <td><strong>Banheiros</strong></td>
                            <td><?= $imovel->BANHEIROS ?></td>
                          </tr>
                        </table>

                        <h3>Descrição</h3>
                        <p><?= $imovel->DESCRICAO .' <br />CRECI: '. $imobiliaria_creci .'<br/> TELEFONE: '.$imobiliaria_telefone   ?></p>
                      </div>
                    </div>

                    
                  </div>
                  <!-- break -->
                  <div class="tab-pane fade" id="location">
                    <div class="row">
                      <div class="col-md-12">
                        <div id="map-property"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <h3>Fale Conosco</h3>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="team-container team-dark">
                          <div class="team-image">
                            <img src="img/<?= $imobiliaria_corretores[0]['FOTO'] ?>" alt="Corretor(a) <?= $imobiliaria_corretores[0]['NOME'] ?>">
                          </div>
                          <div class="team-description">
                            <h3><?= $imobiliaria_corretores[0]['NOME'] ?></h3>
                            <p><i class="fa fa-phone"></i> Telefone : <?= $imobiliaria_corretores[0]['TELEFONE'] ?><br>
                            <i class="fa fa-whatsapp"></i> Whatsapp : <?= $imobiliaria_corretores[0]['WHATSAPP'] ?><br>
                            <i class="fa fa-print"></i> E-Mail : <?= $imobiliaria_corretores[0]['EMAIL'] ?></p>
                            <p>Fique à vontade para entrar em contato comigo, e tirar todas as suas dúvidas sobre este imóvel.</p>
                            <div class="team-social">
                              <span><a href="<?= $imobiliaria_facebook ?>" target="_blank" title="Facebook" rel="tooltip" data-placement="top"><i class="fa fa-facebook"></i></a></span>
                              <span><a href="mailto:<?= $imobiliaria_corretores[0]['EMAIL'] ?>" target="_blank" title="Email" rel="tooltip" data-placement="top"><i class="fa fa-envelope"></i></a></span> 
                              <span><a href="whatsapp://send?text=Olá <?= $imobiliaria_corretores[0]['NOME'] ?>!&phone=+55<?=$imobiliaria_corretores[0]['WHATSAPP'] ?>" target="_blank" title="Whatsapp" rel="tooltip" data-placement="top"><i class="fa fa-whatsapp"></i></a></span> 
                            </div>                     
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6">
                        <form action="POST">
                          <div class="form-group">
                            <label for="name">Nome Completo</label>
                            <input type="text" class="form-control input-lg" placeholder="Seu nome">
                          </div>
                          <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" class="form-control input-lg" placeholder="Seu email">
                          </div>
                          <div class="form-group">
                            <label for="telp">Telefone</label>
                            <input type="text" class="form-control input-lg" placeholder="Seu DDD e telefone">
                          </div>
                          <div class="form-group">
                            <label for="message">Mensagem</label>
                            <textarea class="form-control input-lg" rows="7" placeholder="Mensagem..."></textarea>
                          </div>
                          <div class="form-group">
                            <input type="submit" name="submit" value="Enviar Mensagem" class="btn btn-danger btn-lg">
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end:article -->

          <!-- begin:sidebar -->
          <div class="col-md-3 col-md-pull-9 sidebar">
            <div class="widget-white favorite" align="center">
              <div class="fb-share-button" data-href="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&amp;src=sdkpreparse">Condividi</a></div>
            </div>
            <!-- break -->
            <div class="widget widget-sidebar widget-white">
              <div class="widget-header">
                <h3>Modelos</h3>
              </div>    
              <ul class="list-check">
                <?php foreach($modelosQtde as $modelo){ ?>
                  <li><a href="<?= $imobiliaria_site.'/busca.php?modelo='. $modelo->NOME ?>"><?= $modelo->NOME ?> (<?= $modelo->QTDE ?>)</a></li>
                <?php } ?>
              </ul>
            </div>
            <!-- break -->
            <div class="widget widget-sidebar widget-white">
              <div class="widget-header">
               <h3>Bairros</h3>
              </div>    
              <ul>
                <?php foreach($bairrosQtde as $bairro){ ?>
                  <li><a href="<?= $imobiliaria_site.'/busca.php?bairro='. $bairro->NOME ?>"><?= $bairro->NOME ?> (<?= $bairro->QTDE ?>)</a></li>
                <?php } ?>
              </ul>
            </div>

          </div>
          <!-- end:sidebar -->
          
        </div>
      </div>
    </div>
    <!-- end:content -->

<?php include 'rodape.php'; ?>
  </body>
</html>
