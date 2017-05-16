<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

require "configuracao.php";
require "utilitario.php"; 
require "restclient.php"; 

$api = new RestClient(['base_url' => $api]);

$bairros = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'BAIRROS']);
$bairros = recuperaArray($bairros);

$modelos = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'MODELOS']);
$modelos = recuperaArray($modelos);

$cidades = $api->get("imovel", ['transform' => '1', 'token' => $token, 'busca'=>'CIDADES']);
$cidades = recuperaArray($cidades);

$imoveisVenda = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FINALIDADE,eq,VENDA', 'ANUNCIO,eq,SIM'),
                'page'=>'1,3',
                'order[]'=>'ID_IMOVEL,desc',
                ]);
$imoveisVenda = recuperaArray($imoveisVenda);

$imoveisAluguel = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter'=> array('FINALIDADE,eq,ALUGUEL', 'ANUNCIO,eq,SIM'),
                'page'=>'1,4',
                'order[]'=>'ID_IMOVEL,desc',
                ]);
$imoveisAluguel = recuperaArray($imoveisAluguel);

$imoveisTerreno = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter'=> array('TIPO,eq,TERRENO', 'ANUNCIO,eq,SIM'),
                'page'=>'1,4',
                'order[]'=>'ID_IMOVEL,desc',
                ]);
$imoveisTerreno = recuperaArray($imoveisTerreno);

$imoveisComercial = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                'filter'=> array('TIPO,eq,COMERCIAL', 'ANUNCIO,eq,SIM'),
                'page'=>'1,4',
                'order[]'=>'ID_IMOVEL,desc',
                ]);
$imoveisComercial = recuperaArray($imoveisComercial);

?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="description" content="<?= $imobiliaria_descricao ?>">
    <meta name="keywords" content="<?= $imobiliaria_chaves ?>" />
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $imobiliaria_title ?>" />
    <meta property="og:description" content="<?= $imobiliaria_descricao ?>" />
    <meta property="og:image" content="<?= $imobiliaria_logo_facebook ?>" />
    <meta property="fb:app_id" content="1496712770565168"/>
    <!-- <meta name="author" content="Celula Digital Software"> -->
    <meta property="article:author" content="<?= $imobiliaria_site ?>"/>
    <link rel="shortcut icon" href="<?= $imobiliaria_logo_favicon ?>">

    <title><?= $imobiliaria_title ?></title>

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
    <div id="header" class="header-slide">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="quick-search">
              <div class="row">
                <form role="form" action="busca.php" method="GET">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                        <label for="country">Tipos</label>
                        <select class="form-control" name="tipo">
                        <?php foreach($imovel_tipos as $tipo){ ?>
                          <option value="<?= $tipo ?>" <?= $tipo == $_REQUEST['tipo']? 'selected': '' ?>><?= $tipo ?></option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="location">Cidades</label>
                          <select class="form-control" name='cidade'>
                          <option value="">TODAS</option>
                          <?php foreach($cidades as $cidade){ ?>
                            <option value="<?= $cidade->NOME ?>" <?= $cidade->NOME == $_REQUEST['cidade']? 'selected': '' ?>><?= $cidade->NOME ?></option>
                          <?php } ?>
                          </select>
                      </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      <label for="status">Modelos</label>
                      <select class="form-control" name='modelo'>
                      <option value="">TODOS</option>
                      <?php foreach($modelos as $modelo){ ?>
                        <option value="<?= $modelo->NOME ?>" <?= $modelo->NOME == $_REQUEST['modelo']? 'selected': '' ?>><?= $modelo->NOME ?></option>
                      <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Bairros</label>
                        <select class="form-control" name='bairro'>
                        <option value="">TODOS</option>
                        <?php foreach($bairros as $bairro){ ?>
                          <option value="<?= $bairro->NOME ?>" <?= $bairro->NOME == $_REQUEST['bairro']? 'selected': '' ?>><?= $bairro->NOME ?></option>
                        <?php } ?>
                        </select>

                    </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                          <label for="valor">Valor</label>
                          <select class="form-control" name='valor'>
                          <option value="">TODOS</option>
                          <?php foreach($imovel_valores as $valor=>$nome){ ?>
                            <option value="<?= $valor ?>" <?= $valor == $_REQUEST['valor']? 'selected': '' ?>><?= $nome ?></option>
                          <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      <label for="maxprice">Código</label>
                      <input type="number" name="codigo" value="<?= empty($_REQUEST['codigo'])? '': $_REQUEST['codigo'] ?>" class="form-control" placeholder="0000">
                    </div>
                  </div>


                  </div>
                  <div class="col-md-12 col-sm-12"><input type="submit" value="Buscar" class="btn btn-danger btn-lg btn-block"></div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end:header -->

    <!-- begin:content -->
    <div id="content">
      <div class="container">
        <!-- begin:latest -->
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title">
              <h2>Nossas novidades em Locação</h2>
            </div>
          </div>
        </div>
        <div class="row">

          <?php foreach($imoveisAluguel->imovel as $imovel){?>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="property-container">
              <div class="property-image">
                <a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>"><img src="/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>"></a>
                <div class="property-price">
                  <h4><?= $imovel->TIPO ?></h4>
                  <span><?= formataDinheiro($imovel->VALOR) ?></span>
                </div>
                <div class="property-status">
                  <span>Aluguel</span>
                </div>
              </div>
              <div class="property-features">
                <span><i class="fa fa-hdd-o"></i> <?= $imovel->DORMITORIOS ?> Dorm.</span>
                <span><i class="fa fa-car"></i> <?= $imovel->GARAGEM ?> Garagem.</span>
              </div>
              <div class="property-content">
                <h3><a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>"><?= $imovel->BAIRRO ?></a> <small><?= in_array("ENDERECO", $imobiliaria_retirar)? '': $imovel->ENDERECO ?></small></h3>
              </div>
            </div>
          </div>
          <!-- break -->
          <?php } ?>

        </div>
        <!-- end:latest -->

        <!-- begin:for-sale -->
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title">
              <h2>Nossas novidades em Vendas</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <?php foreach($imoveisVenda->imovel as $imovel){?>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="property-container">
              <div class="property-image">
                <a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>"><img src="/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>"></a>
                <div class="property-price">
                  <h4><?= $imovel->TIPO ?></h4>
                  <span><?= formataDinheiro($imovel->VALOR) ?></span>
                </div>
              </div>
              <div class="property-content">
                <h3><a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>"><?= $imovel->BAIRRO ?></a> <small><?= in_array("ENDERECO", $imobiliaria_retirar)? '': $imovel->ENDERECO ?></small></h3>
                <p><?= $imovel->DESCRICAO ?></p>
              </div>
              <div class="property-features">
                <span><i class="fa fa-home"></i> <?= $imovel->AREA_TERRENO ?> m<sup>2</sup></span>
                <span><i class="fa fa-hdd-o"></i> <?= $imovel->DORMITORIOS ?> Dorm.</span>
                <span><i class="fa fa-car"></i> <?= $imovel->GARAGEM ?> Gara.</span>
              </div>
            </div>
          </div>
          <!-- break -->
          <?php } ?>

        </div>
        <!-- end:for-sale -->

        <!-- begin:for-rent -->
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title">
              <h2>Encontre o Imóvel certo!</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <iframe width="100%" height="273" src="https://www.youtube.com/embed/PW3Dbg8av3I?rel=0" frameborder="0" allowfullscreen></iframe>
          </div>
          <!-- break -->

          <div class="col-md-6 col-sm-12 col-xs-12">
            <iframe width="100%" height="273" src="https://www.youtube.com/embed/y8z5nTxj0gc?rel=0" frameborder="0" allowfullscreen></iframe>
          </div>
          <!-- break -->
        </div>
        <!-- end:for-rent -->
      </div>
    </div>
    <!-- end:content -->

    <!-- begin:testimony -->
    <div id="testimony" style="background-image: url(img/img17.jpg);">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <h2 style="color:white;">Muitas novidades também no Facebook!</h2> <br/>
            <div class="fb-like" data-href="<?= $imobiliaria_facebook ?>" data-layout="standard" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
            <br/><br/>
            <a href="<?= $imobiliaria_facebook ?>" target="_blank" class="btn btn-primary"><b>Venha nos Visitar!</b></a>
            
          </div>
        </div>
      </div>
    </div>
    <!-- end:testimony -->

    <!-- begin:news -->
    <div id="news">
      <div class="container">
        <div class="row">
          <!-- begin:blog -->
          <div class="col-md-4 col-sm-4">
            <div class="row">
              <div class="col-md-12">
                <div class="heading-title heading-title-sm bg-white">
                  <h2>Terrenos Destaque</h2>
                </div>
              </div>
            </div>
            <!-- break -->

            <div class="row">
              <div class="col-md-12">
                     <?php foreach($imoveisTerreno->imovel as $imovel){?>
                      <div class="post-img" style="background: url(/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>);"><h3><?= $imovel->FINALIDADE ?></h3></div>
                      <div class="post-content">
                        <a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>">
                          <span><i class="fa fa-home"></i> <?= $imovel->AREA_TERRENO ?> m<sup>2</sup></span><br/>
                          <small><?= $imovel->BAIRRO ?></small><br/>
                          <small><?= formataDinheiro($imovel->VALOR) ?></small>
                        </a>
                        <div class="heading-title">&nbsp;</div>
                      </div>
                    <!-- break -->
                    <?php } ?>

              </div>
            </div>
            <!-- break -->

          </div>
          <!-- end:blog -->

          <!-- begin:popular -->
          <div class="col-md-4 col-sm-4">
            <div class="row">
              <div class="col-md-12">
                <div class="heading-title heading-title-sm bg-white">
                  <h2>Comercial em Destaque</h2>
                </div>
              </div>
            </div>
            <!-- break -->

            <div class="row">
              <div class="col-md-12">
                <div class="post-container">
                    <?php foreach($imoveisComercial->imovel as $imovel){?>
                      <div class="post-img" style="background: url(/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>);"><h3><?= $imovel->FINALIDADE ?></h3></div>
                      <div class="post-content">
                        <a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>">
                          <span><i class="fa fa-home"></i> <?= $imovel->AREA_TERRENO ?> m<sup>2</sup> / </span>
                          <span><i class="fa fa-hdd-o"></i> <?= $imovel->DORMITORIOS ?> Sala</span><br/ >
                          <small><?= $imovel->BAIRRO ?></small><br/>
                          <small><?= formataDinheiro($imovel->VALOR) ?></small>
                        </a>
                          <div class="heading-title">&nbsp;</div>
                      </div>
                    <!-- break -->
                    <?php } ?>
                  </div>
              </div>
            </div>
            <!-- break -->

          </div>
          <!-- end:popular -->

          <!-- begin:agent -->
          <div class="col-md-4 col-sm-4">
            <div class="row">
              <div class="col-md-12">
                <div class="heading-title heading-title-sm bg-white">
                  <h2>Atendimento</h2>
                </div>
              </div>
            </div>
            <!-- break -->

            <div class="row">
              <div class="col-md-12">
              <?php foreach( $imobiliaria_corretores as $corretor){ ?>
                  <div class="post-container post-noborder">
                    <div class="post-img" style="background: url(img/<?= $corretor['FOTO'] ?>);"></div>
                    <div class="post-content list-agent">
                      <div class="heading-title">
                        <h2><a href="#"><?= $corretor['NOME'] ?></a></h2>
                      </div>
                      <div class="post-meta">
                        <span><i class="fa fa-phone"></i> <a href="tel:"><?= $corretor['TELEFONE'] ?></a></span><br>
                        <span><i class="fa fa-whatsapp"></i> <a href="whatsapp://send?text=Olá <?= $corretor['NOME'] ?>!&phone=+55<?= $corretor['WHATSAPP'] ?>"><?= $corretor['WHATSAPP'] ?></a></span>
                        <span><i class="fa fa-envelope-o"></i> <?= $corretor['EMAIL'] ?></span><br>
                      </div>
                    </div>
                  </div>
                  <!-- break -->
              <?php } ?>

              </div>
            </div>
            <!-- break -->

          </div>
          <!-- end:agent -->
        </div>
      </div>
    </div>
    <!-- end:news -->

    <!-- begin:subscribe -->
    <div id="subscribe">
      <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" align="center">
              <h1><a href="tel:<?= $imobiliaria_telefone ?>"><?= $imobiliaria_telefone ?></a></h1>
          </div>
        </div>
      </div>
    </div>
    <!-- end:subscribe -->

    <!-- begin:partner -->
    <div id="partner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="heading-title bg-white">
              <h2>Empreendimentos</h2>
            </div>
          </div>
        </div>
        <!-- break -->

        <div class="row">
          <div class="col-md-12">
            <div class="jcarousel-wrapper">
              <div class="jcarousel">
                <ul>
                  <?php foreach($imobiliaria_empreendimentos as $empreendimento) { ?>
                    <li><a href="<?= $empreendimento['LINK'] ?>" alt="<?= $empreendimento['NOME'] ?>" target="_blank" ><img src="<?= $empreendimento['IMAGEM'] ?>" alt="<?= $empreendimento['NOME'] ?>" ></a></li>
                  <?php } ?>
                </ul>
              </div>
              <a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
              <a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
              <!-- <p class="jcarousel-pagination"></p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end:partner -->

<?php include 'rodape.php'; ?>

  </body>
</html>
