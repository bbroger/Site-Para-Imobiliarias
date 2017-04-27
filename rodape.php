<!-- begin:footer -->
<div id="footer">
    <div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="widget">
            <h3>Busca Rápida</h3>
            <ul class="list-unstyled">
            <li><a href="<?= $imobiliaria_site.'/busca.php?cidade='.$imobiliaria_cidade.'&modelo=TERRENO&ordem=VALOR%2Casc' ?>">Terrenos em <?= $imobiliaria_cidade ?></a></li>
            <li><a href="<?= $imobiliaria_site.'/busca.php?cidade='.$imobiliaria_cidade.'&modelo=APARTAMENTO&ordem=VALOR%2Casc' ?>">Apartamentos em <?= $imobiliaria_cidade ?></a></li>
            <li><a href="<?= $imobiliaria_site.'/busca.php?cidade='.$imobiliaria_cidade.'&modelo=CASA&ordem=VALOR%2Casc' ?>">Casas em <?= $imobiliaria_cidade ?></a></li>
            <li><a href="<?= $imobiliaria_site.'/busca.php?cidade='.$imobiliaria_cidade.'&modelo=COMERCIAL&ordem=VALOR%2Casc' ?>">Comércio em <?= $imobiliaria_cidade ?></a></li>
            <li><a href="<?= $imobiliaria_site.'/busca.php?cidade='.$imobiliaria_cidade.'&modelo=GALPÃO&ordem=VALOR%2Casc' ?>">Galpões em <?= $imobiliaria_cidade ?></a></li>
            <?php if($imobiliaria_android){ ?>
                <li><a href="<?= $imobiliaria_android ?>" target="_blank">Nosso App Android</a></li>
            <?php } ?>
            </ul>
        </div>
        </div>
        <!-- break -->
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="widget">
            <h3>Documentos</h3>
            <ul class="list-unstyled">
            <li><a href="#">Para Locação</a></li>
            <li><a href="#">Para Vendas</a></li>
            <li><a href="#">Fiadores</a></li>
            <li><a href="#">Outros</a></li>
            </ul>
        </div>
        </div>
        <!-- break -->
        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="widget">
            <h2><?= $imobiliaria_nome ?></h2>
            <address>
            <strong>CRECI: <?= $imobiliaria_creci ?></strong><br>
            <a href="https://www.google.com/maps/place/<?= str_replace(" ","+",$imobiliaria_endereco) ?>,+Brasil" target="_blank"><?= $imobiliaria_endereco ?></a><br>
            <br>
            Tel. : <?= $imobiliaria_telefone ?><br>
            Email : <?= $imobiliaria_email ?>
            </address>
        </div>
        </div>
        <!-- break -->
    </div>
    <!-- break -->

    <!-- begin:copyright -->
    <div class="row">
        <div class="col-md-12 copyright">
        <p>Copyright &copy; <?= date('Y') ?> <?= $imobiliaria_title ?> & Célula Digital Software.</p>
        <a href="#top" class="btn btn-danger scroltop"><i class="fa fa-angle-up"></i></a>
        <ul class="list-inline social-links">

            <?php if ($imobiliaria_android){ ?>
            <li><a href="<?= $imobiliaria_android ?>" target="_blank" class="icon-android" rel="tooltip" title="Conheça nosso App Android!" data-placement="bottom" data-original-title="App Android"><i class="fa fa-android"></i></a></li>
            <?php } ?>

            <?php if ($imobiliaria_facebook){ ?>
            <li><a href="<?= $imobiliaria_facebook ?>" target="_blank" class="icon-facebook" rel="tooltip" title="Nossa Página no Facebook!" data-placement="bottom" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>

            <?php if ($imobiliaria_youtube){ ?>
            <li><a href="<?= $imobiliaria_youtube ?>" target="_blank" class="icon-youtube" rel="tooltip" title="Nossos Vídeos!" data-placement="bottom" data-original-title="Youtube"><i class="fa fa-youtube"></i></a></li>
            <?php } ?>

        </ul>
        </div>
    </div>
    <!-- end:copyright -->

    </div>
</div>
<!-- end:footer -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?language=pt-br?&key=<?= $api_js_google ?>"></script>
<script src="https://cdn.jsdelivr.net/gmap3/7.2.0/gmap3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jcarousel/0.3.5/jquery.jcarousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.1/imagesloaded.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.0/masonry.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script src="cor_<?= $imobiliaria_cor ?>/js/script.js"></script>