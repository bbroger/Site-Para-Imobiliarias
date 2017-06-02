<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
ini_set('display_errors', 1);

require "configuracao.php";
require "utilitario.php"; 
require "restclient.php"; 

if ( empty($_REQUEST['codigo']) ){
  header("Location: ".$imobiliaria_site);
  die();
} else
  $codigo = $_REQUEST['codigo'];

$api = new RestClient(['base_url' => $api]);

$bairros = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'BAIRROS']);
$bairros = recuperaArray($bairros);

$bairrosQtde = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'BAIRROSQTDE']);
$bairrosQtde = recuperaArray($bairrosQtde);

$tipos = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'MODELOS']);
$tipos = recuperaArray($tipos);

$modelosQtde = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'MODELOSQTDE']);
$modelosQtde = recuperaArray($modelosQtde);

$cidades = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'CIDADES']);
$cidades = recuperaArray($cidades);

$imovel = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter[]'=> 'COD_IMOVEL,eq,'.$codigo,
                'page'=>'1,1',
                ]);

$imovel = recuperaArray($imovel);
$imovel = $imovel->imovel[0];

if ( empty($imovel) ){
  echo '
      <meta property="og:type" content="article" />
      <meta property="og:title" content="ERRO!" />
      <meta property="og:description" content="O imóvel '.$codigo.' ainda não está online..." />
      <meta property="fb:app_id" content="1496712770565168"/>
  ';
  die("ERRO: O imóvel ".$codigo." ainda não está online... Aguarde a exportação do sistema interno. (Geralmente 30min)");
}

$fotos = $api->get("fotos", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FOTO,ncs,_60_', 'COD_IMOVEL,eq,'.$codigo), 
                'order[]'=>'foto,asc',
                ]);

$fotos = recuperaArray($fotos);

$fotosFachada = $api->get("fotos", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FOTO,cs,_60_', 'COD_IMOVEL,eq,'.$codigo), 
                'order[]'=>'foto,asc',
                ]);

$fotosFachada = recuperaArray($fotosFachada);

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
    <meta property="og:title" content="IMÓVEL NO BAIRRO <?= $imovel->BAIRRO .' ('. $imovel->CIDADE .')' ?>" />
    <meta property="og:description" content="<?= $imovel->DESCRICAO ?>" />
    <meta property="og:image" content="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; ?>/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>" />
    <meta property="fb:app_id" content="1496712770565168"/>
    <!-- <meta name="author" content="Celula Digital Software"> -->
    <meta property="article:author" content="<?= $imobiliaria_site ?>"/>
    <link rel="shortcut icon" href="<?= $imobiliaria_logo_favicon ?>">
    <meta name="robots" content="index,follow">
    <title>Imóvel, <?= $imovel->BAIRRO.', '. $imovel->ID_IMOVEL .', '. (in_array("ENDERECO", $imobiliaria_retirar)? '': $imovel->ENDERECO) ?></title>

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


    <!-- begin:header -->
    <div id="header" class="heading" style="background-image: url(/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>);">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12">
            <div class="quick-search">
              <div class="row">
                <form role="form" action="busca.php" method="GET">
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label for="desejo">Desejo</label>
                        <select class="form-control" name="desejo">
                        <?php foreach($imovel_desejos as $valor=>$nome){ ?>
                          <option value="<?= $valor ?>" <?= $valor == $imovel->FINALIDADE? 'selected': '' ?>><?= $nome ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                       <label for="valor">Valor</label>
                          <select class="form-control" name='valor'>
                          <option value="">TODOS</option>
                          <?php foreach($imovel_valores as $valor=>$nome){ ?>
                            <option value="<?= $valor ?>"><?= $nome ?></option>
                          <?php } ?>
                          </select>
                    </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                      <label for="tipo">Tipos</label>
                        <select class="form-control" name='tipo'>
                        <option value="">TODOS</option>
                        <?php foreach($tipos as $tipo){ ?>
                          <option value="<?= $tipo->NOME ?>" <?= $tipo->NOME == $imovel->TIPO? 'selected': '' ?>><?= $tipo->NOME ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="codigo">Código</label>
                      <input type="number" name="codigo" value="" class="form-control" placeholder="0000">
                    </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label for="cidade">Cidades</label>
                          <select class="form-control" name='cidade'>
                          <option value="">TODAS</option>
                          <?php foreach($cidades as $cidade){ ?>
                            <option value="<?= $cidade->NOME ?>" <?= $cidade->NOME == $imovel->CIDADE? 'selected': '' ?>><?= $cidade->NOME ?></option>
                          <?php } ?>
                          </select>
                    </div>
                    <div class="form-group">
                      &nbsp;
                    </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label for="location">Bairros</label>
                        <select class="form-control" name='bairro'>
                        <option value="">TODOS</option>
                        <?php foreach($bairros as $bairro){ ?>
                          <option value="<?= $bairro->NOME ?>" <?= $bairro->NOME == $imovel->BAIRRO? 'selected': '' ?>><?= $bairro->NOME ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="maxprice">&nbsp;</label>
                      <input type="submit" name="submit" value="FILTRAR" class="btn btn-danger btn-block">
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <ol class="breadcrumb">
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $imovel->FINALIDADE ?></b></li>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $imovel->TIPO ?></b></li>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $imovel->CIDADE ?></b></li>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $imovel->BAIRRO ?></b></li>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= formataDinheiro($imovel->VALOR) ?></b></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end:header -->


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
                        <h2>IMÓVEL NO BAIRRO <?= $imovel->BAIRRO ?></h2>
                        <div id="slider-property" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators">
                            <!-- FACHADA -->
                            <?php $num = 0; foreach($fotosFachada->fotos as $foto){ ?>
                              <li data-target="#slider-property" data-slide-to="<?= $num ?>" class="<?= $num == 0? 'active': '';?>">
                                <img src="/fotos_imoveis/<?= strtoupper($foto->FOTO) ?>" alt="<?= $foto->DESCRICAO ?>">
                              </li>
                            <?php $num++; } 
                            echo "<!-- END FACHADA -->";
                            foreach($fotos->fotos as $foto){ ?>
                              <li data-target="#slider-property" data-slide-to="<?= $num ?>" class="">
                                <img src="/fotos_imoveis/<?= strtoupper($foto->FOTO) ?>" alt="<?= $foto->DESCRICAO ?>">
                              </li>
                            <?php $num++; } ?>
                          </ol>
                          <div class="carousel-inner">
                            <?php $num = 0; foreach($fotosFachada->fotos as $foto){ ?>
                              <div class="item <?= $num == 0? 'active': '';?>">
                                <img src="/fotos_imoveis/<?= strtoupper($foto->FOTO) ?>" alt="<?= $foto->DESCRICAO ?>">
                              </div>
                            <?php $num++; }
                             
                             foreach($fotos->fotos as $foto){ ?>
                              <div class="item">
                                <img src="/fotos_imoveis/<?= strtoupper($foto->FOTO) ?>" alt="<?= $foto->DESCRICAO ?>">
                              </div>
                            <?php } ?>
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
                            <td><?= (in_array("ENDERECO", $imobiliaria_retirar)? '': $imovel->ENDERECO) .', '. $imovel->BAIRRO .', '. $imovel->CIDADE .'-'. $imovel->ESTADO ?></td>
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
                            <p><i class="fa fa-phone"></i> Telefone : <b><?= $imobiliaria_corretores[0]['TELEFONE'] ?></b><br>
                            <?php if ( !empty($imobiliaria_corretores[0]['WHATSAPP']) ){ ?>
                              <i class="fa fa-whatsapp"></i> Whatsapp : <b><?= $imobiliaria_corretores[0]['WHATSAPP'] ?></b><br>
                            <?php } ?>
                            <?php if ( !empty($imobiliaria_corretores[0]['SKYPE']) ){ ?>
                              <i class="fa fa-skype"></i> Skype : <b><?= $imobiliaria_corretores[0]['SKYPE'] ?></b><br>
                            <?php } ?>
                            <i class="fa fa-print"></i> E-Mail : <b><?= $imobiliaria_corretores[0]['EMAIL'] ?></b></p>
                            <p><b>Fique à vontade para entrar em contato conosco, e tirar todas as suas dúvidas sobre este imóvel.</b></p>
                            <div class="team-social">
                              <span><a href="<?= $imobiliaria_facebook ?>" target="_blank" title="Facebook" rel="tooltip" data-placement="top"><i class="fa fa-facebook"></i></a></span>
                              <span><a href="mailto:<?= $imobiliaria_corretores[0]['EMAIL'] ?>" target="_blank" title="Email" rel="tooltip" data-placement="top"><i class="fa fa-envelope"></i></a></span> 
                              <?php if ( !empty($imobiliaria_corretores[0]['WHATSAPP']) ){ ?>
                                <span><a href="whatsapp://send?text=Olá <?= $imobiliaria_corretores[0]['NOME'] ?>!&phone=+55<?=$imobiliaria_corretores[0]['WHATSAPP'] ?>" target="_blank" title="Whatsapp" rel="tooltip" data-placement="top"><i class="fa fa-whatsapp"></i></a></span> 
                              <?php } ?>
                              <?php if ( !empty($imobiliaria_corretores[0]['SKYPE']) ){ ?>
                                <span><a href="skype:<?= $imobiliaria_corretores[0]['SKYPE'] ?>?chat" target="_blank" title="Skype" rel="tooltip" data-placement="top"><i class="fa fa-skype"></i></a></span> 
                              <?php } ?>
                            </div>                     
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6">
                        <form role="form" action="contato.php" method="POST">
                          <input type="hidden" name="link" value="<?= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>">
                          <input type="hidden" name="para" value="<?= $imobiliaria_corretores[0]['EMAIL'] ?>">
                          <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" pattern=".{10,}" class="form-control input-lg" placeholder="Seu nome" required>
                          </div>
                          <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" pattern=".{10,}" class="form-control input-lg" placeholder="Seu email" required>
                          </div>
                          <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="tel" name="telefone" pattern=".{8,13}" class="form-control input-lg" placeholder="Seu DDD e telefone" required>
                          </div>
                          <div class="form-group">
                            <label for="message">Mensagem</label>
                            <textarea name="texto" minlength="20" class="form-control input-lg" rows="7" placeholder="Mensagem..." required></textarea>
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
                <h3>Tipos de Imóveis</h3>
              </div>    
              <ul class="list-check">
                <?php foreach($modelosQtde as $modelo){ ?>
                  <li><a href="<?= $imobiliaria_site.'/busca.php?modelo='. $modelo->NOME ?>"><b><?= $modelo->NOME ?></b> (<?= $modelo->QTDE ?>)</a></li>
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
                  <li><a href="<?= $imobiliaria_site.'/busca.php?bairro='. $bairro->NOME ?>"><b><?= $bairro->NOME ?></b> (<?= $bairro->QTDE ?>)</a></li>
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

<script>
      /* map property */
    $('a[href="#location"]').on('shown.bs.tab', function(){
        $("#map-property").gmap3({
        address: "<?= $imovel->BAIRRO .', '. $imovel->CIDADE .', '. $imovel->ESTADO .', BRASIL' ?>",
        zoom: 13,
        mapTypeId : google.maps.MapTypeId.ROADMAP
      })
      .circle({
        address: "<?= $imovel->BAIRRO .', '. $imovel->CIDADE .', '. $imovel->ESTADO .', BRASIL' ?>",
        radius : 300,
        fillColor : "#FFAF9F",
        strokeColor : "#FF512F"
      });
    })
</script>

  </body>
</html>
