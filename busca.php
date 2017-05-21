<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

require "configuracao.php";
require "utilitario.php"; 
require "restclient.php"; 


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

$filter = array('ANUNCIO,eq,SIM');

  if (!empty($_REQUEST['ordem']))
    $ordem = $_REQUEST['ordem'];
  else
    $ordem = 'ID_IMOVEL,desc';

  if (!empty($_REQUEST['codigo']))
    array_push($filter, 'COD_IMOVEL,eq,'.$_REQUEST['codigo']);

  if (!empty($_REQUEST['desejo']))
    array_push($filter, 'FINALIDADE,eq,'.$_REQUEST['desejo']);

  if (!empty($_REQUEST['tipo']))
    array_push($filter, 'TIPO,eq,'.$_REQUEST['tipo']);

  if (!empty($_REQUEST['cidade']))
    array_push($filter, 'CIDADE,eq,'.$_REQUEST['cidade']);

  if (!empty($_REQUEST['bairro']))
    array_push($filter, 'BAIRRO,eq,'.$_REQUEST['bairro']);
  
  if (!empty($_REQUEST['valor'])){
      $valores = explode("-", $_REQUEST['valor']);

      if ($valores[1] == '0')
        array_push($filter, 'VALOR,ge,'.$valores[0]);
      else
        array_push($filter, 'VALOR,bt,'.implode(',',$valores));
  }

if ( count($filter) > 1){
  $imoveisResultado = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                  'filter'=> $filter,
                  'order[]'=>$ordem,
                  ]);
} else {
  $imoveisResultado = $api->get("imovel", ['transform' => '1', 'token' => $token, 
                  'filter'=> $filter,
                  'order[]'=>$ordem,
                  'page'=>'1,20',
                  ]);
}
$imoveisResultado = recuperaArray($imoveisResultado);

?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="description" content="Busca de Imóveis, <?= $imobiliaria_descricao ?>">
    <meta name="keywords" content="Busca de Imóveis, <?= $imobiliaria_chaves ?>" />
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Busca de Imóveis - <?= $imobiliaria_nome ?>" />
    <meta property="og:description" content="<?= $imobiliaria_descricao ?>" />
    <meta property="og:image" content="<?= $imobiliaria_logo_facebook ?>" />
    <meta property="fb:app_id" content="1496712770565168"/>
    <!-- <meta name="author" content="Celula Digital Software"> -->
    <meta property="article:author" content="<?= $imobiliaria_site ?>"/>
    <link rel="shortcut icon" href="<?= $imobiliaria_logo_favicon ?>">

    <title>Busca de Imóveis - <?= $imobiliaria_title ?></title>

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
    <div id="header" class="heading" style="background-image: url(img/img01.jpg);">
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
                        <?php foreach($imovel_desejos as $valor=>$nome){?>
                          <option value="<?= $valor ?>" <?= $valor == $_REQUEST['desejo']? 'selected': '' ?>><?= $nome ?></option>
                        <?php } ?>
                        </select>
                    </div>
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
                  <!-- break -->
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                      <label for="tipo">Tipos</label>
                        <select class="form-control" name='tipo'>
                        <option value="">TODOS</option>
                        <?php foreach($tipos as $tipo){ ?>
                          <option value="<?= $tipo->NOME ?>" <?= $tipo->NOME == $_REQUEST['tipo']? 'selected': '' ?>><?= $tipo->NOME ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="codigo">Código</label>
                      <input type="number" name="codigo" value="<?= empty($_REQUEST['codigo'])? '': $_REQUEST['codigo'] ?>" class="form-control" placeholder="0000">
                    </div>
                  </div>
                  <!-- break -->
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label for="cidade">Cidades</label>
                          <select class="form-control" name='cidade'>
                          <option value="">TODAS</option>
                          <?php foreach($cidades as $cidade){ ?>
                            <option value="<?= $cidade->NOME ?>" <?= $cidade->NOME == $_REQUEST['cidade']? 'selected': '' ?>><?= $cidade->NOME ?></option>
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
                        <label for="bairro">Bairros</label>
                        <select class="form-control" name='bairro'>
                        <option value="">TODOS</option>
                        <?php foreach($bairros as $bairro){ ?>
                          <option value="<?= $bairro->NOME ?>" <?= $bairro->NOME == $_REQUEST['bairro']? 'selected': '' ?>><?= $bairro->NOME ?></option>
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
              <?php if (!empty($_REQUEST['tipo'])) { ?>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $_REQUEST['tipo'] ?></b></li>
              <?php } ?>
              <?php if (!empty($_REQUEST['modelo'])) { ?>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $_REQUEST['modelo'] ?></b></li>
              <?php } ?>
              <?php if (!empty($_REQUEST['cidade'])) { ?>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $_REQUEST['cidade'] ?></b></li>
              <?php } ?>
              <?php if (!empty($_REQUEST['bairro'])) { ?>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $_REQUEST['bairro'] ?></b></li>
              <?php } ?>
              <?php if (!empty($_REQUEST['valor'])) { ?>
                <li class="active"><b style="text-shadow: -1px 0 gray, 0 1px gray, 1px 0 black, 0 -1px black;"><?= $_REQUEST['valor'] ?></b></li>
              <?php } ?>
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
              <div class="col-md-12">
                <div class="heading-title heading-title-alt">
                  <h3>Resultado da busca</h3>
                </div>
              </div>
            </div>
            <!-- begin:sorting -->
            <div class="row sort">
              <div class="col-md-4 col-sm-4 col-xs-3">
                <a class="btn btn-danger"><i class="fa fa-th"></i></a>
                <span><strong><?= count($imoveisResultado->imovel) ?></strong> encontrados.</span>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-9">
                <form class="form-inline" role="form" action="busca.php" method="GET">
                  <input type="hidden" name="tipo" value="<?= $_REQUEST['tipo'] ?>">
                  <input type="hidden" name="cidade" value="<?= $_REQUEST['cidade'] ?>">
                  <input type="hidden" name="modelo" value="<?= $_REQUEST['modelo'] ?>">
                  <input type="hidden" name="bairro" value="<?= $_REQUEST['bairro'] ?>">
                  <input type="hidden" name="valor" value="<?= $_REQUEST['valor'] ?>">
                  <span>Ordenar por : </span>
                  <div class="form-group">
                    <label class="sr-only" for="sortby">Ordenar por : </label>
                    <select class="form-control" name="ordem" onchange="this.form.submit()">
                      <option value="">Novos Anúncios</option>
                      <option value="BAIRRO,asc" <?= $_REQUEST['ordem'] == "BAIRRO,asc"? 'selected': ''; ?>>Bairro</option>
                      <option value="ENDERECO,asc" <?= $_REQUEST['ordem'] == "ENDERECO,asc"? 'selected': ''; ?>>Rua</option>
                      <option value="DORMITORIOS,desc" <?= $_REQUEST['ordem'] == "DORMITORIOS,desc"? 'selected': ''; ?>>Dormitórios</option>
                      <option value="ID_IMOVEL,desc" <?= $_REQUEST['ordem'] == "ID_IMOVEL,desc"? 'selected': ''; ?>>Novidades</option>
                      <option value="VALOR,asc" <?= $_REQUEST['ordem'] == "VALOR,asc"? 'selected': ''; ?>>Valor Menor Primeiro</option>
                      <option value="VALOR,desc" <?= $_REQUEST['ordem'] == "VALOR,desc"? 'selected': ''; ?>>Valor Maior Primeiro</option>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <!-- end:sorting -->

            <!-- begin:product -->
            <div class="row container-realestate">
                <?php foreach($imoveisResultado->imovel as $imovel){ ?>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="property-container">
                      <div class="property-image">
                        <a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>"><img src="/fotos_imoveis/<?= getFotoFachada($imovel->ID_IMOVEL) ?>" alt="<?= in_array("ENDERECO", $imobiliaria_retirar)? '':$imovel->ENDERECO ?>"></a>
                        <div class="property-price">
                        <span><?= formataDinheiro($imovel->VALOR) ?></span>
                      </div>
                      
                      <div class="property-status">
                        <span><?= $imovel->FINALIDADE ?></span>
                      </div>
                    </div>
                    
                    <div class="property-features">
                      <span><i class="fa fa-hdd-o"></i> <?= $imovel->DORMITORIOS ?> Dorm.</span>
                      <span><i class="fa fa-hashtag"></i> Cód. <?= $imovel->COD_IMOVEL ?></span>
                      </div>
                      <div class="property-content">
                        <h4><?= $imovel->TIPO ?></h4>
                        <h3><a href="<?= $imobiliaria_site ?>/imovel.php?codigo=<?= $imovel->COD_IMOVEL ?>".><?= $imovel->BAIRRO ?></a> <small><?= in_array("ENDERECO", $imobiliaria_retirar)? '':$imovel->ENDERECO ?></small></h3>
                      </div>
                    </div>
                  </div>
                  <!-- break -->
                <?php } ?>
            </div>
            <!-- end:product -->

          </div>
          <!-- end:article -->

          <!-- begin:sidebar -->
          <div class="col-md-3 col-md-pull-9 sidebar">
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
            <!-- break -->

          </div>
          <!-- end:sidebar -->
          
        </div>
      </div>
    </div>
    <!-- end:content -->

<?php include 'rodape.php'; ?>
    
  </body>
</html>
