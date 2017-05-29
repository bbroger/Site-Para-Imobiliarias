<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=1496712770565168";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- begin:navbar -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-top">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="<?= $imobiliaria_logo_pequeno ?>" class="img-responsive" style="padding-top: 20px;">
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-top">
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="index.php"><b>Home</b></a></li>
        <li><a href="#modal-quemsomos" data-toggle="modal" data-target="#modal-quemsomos"><b>Quem Somos</b></a></li>
        <li><a href="busca.php"><b>Imóveis</b></a></li>
        <li><a href="#modal-contato" data-toggle="modal" data-target="#modal-contato"><b>Contato</b></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
<!-- end:navbar -->

<!-- begin:modal-Quem Somos -->
<div class="modal fade" id="modal-quemsomos" tabindex="-1" role="dialog" aria-labelledby="modal-quemsomos" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Quem Somos?</h4>
      </div>
      <div class="modal-body">
      <div align="center"><img src="<?= $imobiliaria_logo_grande ?>"></div><br/>
      <div align="justify"><?= $imobiliaria_quemsomos ?></div><br/>
      NOSSO CRECI: <?= $imobiliaria_creci ?>
      </div>
      <div class="modal-footer">
        <?php if ($imobiliaria_facebook){ ?>
          <a href="<?= $imobiliaria_facebook ?>photos/?tab=albums" target="_blank" class="btn btn-danger btn-block btn-lg"><i class="fa fa-facebook"></i> Faça parte de nossa comunidade!</a>
        <?php } ?>
        <br />
        <?php if ($imobiliaria_android){ ?>
          <a href="<?= $imobiliaria_android ?>" target="_blank" class="btn btn-danger btn-block btn-lg"><i class="fa fa-android"></i> Baixe nosso Aplicativo!</a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<!-- end:modal-Quem Somos -->

<!-- begin:modal-contato -->
<div class="modal fade" id="modal-contato" tabindex="-1" role="dialog" aria-labelledby="modal-contato" aria-hidden="true">
<form role="form" action="contato.php" method="POST">
  <input type="hidden" name="link" value="<?= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Formulário de Contato</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <select class="form-control" name='para' required="true">
              <option value="">DEPARTAMENTO</option>
              <?php foreach($imobiliaria_departamentos as $imobiliaria_departamento){ ?>
                <option value="<?= $imobiliaria_departamento['EMAIL'] ?>"><?= $imobiliaria_departamento['NOME'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <input type="text" name="nome" class="form-control input-lg" placeholder="Seu nome..." required="true">
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control input-lg" placeholder="Seu email..." required="true">
          </div>
          <div class="form-group">
            <input type="tel" name="telefone" class="form-control input-lg" placeholder="Seu telefone..." required="true">
          </div>
          <div class="form-group">
            <textarea name="texto" placeholder="Sua mensagem..." class="form-control input-lg" rows="3" required="true"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <p>Teremos o maior prazer em atendê-lo.</p>
        <input type="submit" class="btn btn-danger btn-block btn-lg" name="acao" value="Enviar Mensagem">
      </div>
    </div>
  </div>
  </form>
</div>
<!-- end:modal-servicos -->

