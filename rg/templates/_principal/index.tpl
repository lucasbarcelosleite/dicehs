<!DOCTYPE html>
<html>
<head>
	<title>{page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{dir_css}/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{dir_css}/theme.css">
    <link rel="stylesheet" type="text/css" href="{dir_css}/index.css" media="screen" />

    <link rel="icon" type="image/ico" href="{dir_img}/favicon.ico">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{dir_css}/lib/animate.css" media="screen, projection">    

    <meta name="description" content="Dice Hobby Store, rede de lojas especializadas em Magic: The Gathering, Marvel Battle Scenes, Pok&eacute;mon, Yu-Gi-Oh!, RPG, com realiza&ccedil;&atilde;o peri&oacute;dica de eventos" />

    <meta property="fb:admins" content="{fb_admin}"/>

    <meta property="og:title" content="{og_title}" />
    <meta property="og:description" content="Dice Hobby Store, rede de lojas especializadas em Magic: The Gathering, Marvel Battle Scenes, Pok&eacute;mon, Yu-Gi-Oh!, RPG, com realiza&ccedil;&atilde;o peri&oacute;dica de eventos" />
    <meta property="og:image" content="{og_image}" />
    <meta property="og:url" content="{og_url}"/>
    <meta property="og:site_name" content="{site_name}"/>
    <meta property="og:type" content="website" />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body class="pull_top {css_menu}">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div class="navbar transparent navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="{live_site}">
                <img src="{dir_img}/logo-dice.png" width="100" height="100" />
            </a>
            <a class="brand-text" href="{live_site}">
                <strong>Dice Hobby Store</strong>
            </a>
            <span class="city">
                <strong>Rio Grande / RS</strong> <br />
                <a href="http://www.dicehs.com.br/sl/">Acessar loja S&atilde;o Leopoldo/RS</a>
            </span>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <!-- BEGIN MENU_ITEM -->
                    <li><a href="{link}">{titulo}</a></li>
                    <!-- END MENU_ITEM -->
                </ul>
            </div>
        </div>
      </div>
    </div>

    <!-- BEGIN STR_HOME -->
    {main_body}
    <!-- END STR_HOME -->

    <!-- BEGIN STR_INTERNA -->
    <div id="container-interna">
        <div class="container">
            <div class="section_header">
                <h3>{titulo}</h3>
            </div>

            {main_body}

            <br class="clearfix" />
            <div class="fb-like" data-href="{og_url}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>                     
        </div>
    </div>
    <!-- END STR_INTERNA -->


    <!-- starts footer -->
    <footer id="footer">
        <div class="container">
            <div class="row sections">
                <div class="span4 recent_posts">
                    <h3 class="footer_header">
                        Onde Estamos?
                    </h3>
                    <div class="wrapper">
                        <div class="onde-estamos">
                        {endereco_dice}
                        
                        <a href="https://www.google.com.br/maps/preview#!q=Shopping+Figueiras%2C+Rio+Grande%2C+RS&data=!1m4!1m3!1d15802!2d-52.1046203!3d-32.0315274!4m15!2m14!1m13!1s0x95119c070ade2551%3A0xef218e9bd65922d2!3m8!1m3!1d258023!2d-51.1593094!3d-30.0997213!3m2!1i1410!2i897!4f13.1!4m2!3d-32.032277!4d-52.104938"><img src="{dir_img}/ver_maps.jpg" /></a>
                        </div>
                    </div>
                    
                </div>
                <div class="span4 testimonials">
                    <h3 class="footer_header">
                        Conhe&ccedil;a Tamb&eacute;m
                    </h3>
                    <div class="wrapper">
                        <div class="quote">
                            <a href="http://www.dicehs.com.br/sl/" title="Dice Hobby Store São Leopoldo"><img src="{dir_img}/dice-sl.jpg" width="340" height="340"></a>
                        </div>
                    </div>
                </div>
                <div class="span4 contact">
                    <h3 class="footer_header">
                        Siga-nos
                    </h3>

                    <div class="fb-like-box" data-href="https://www.facebook.com/pages/Dice-Hobby-Store/226767444076484" data-width="300" data-colorscheme="dark" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script type="text/javascript" src="{dir_js}/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="{dir_js}/bootstrap.min.js"></script>
    <script type="text/javascript" src="{dir_js}/theme.js"></script>
    <script type="text/javascript" src="{dir_js}/index-slider.js"></script>	

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-46106634-1', 'dicehs.com.br');
      ga('send', 'pageview');

    </script>    
</body>
</html>