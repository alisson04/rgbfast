<?php
require_once(__DIR__.'/config/connection.php');

$COLORS[0] = '#eae9e9';
$COLORS[1] = '#b3b3b3';
$COLORS[2] = '#777575';
$COLORS[3] = '#454545'; // Footer h4, Footer social-links

$empresa    = [];
$fotos      = [];

// BUSCA EMRPRESA
if(!$msg_error){
    try {
        $sql = [];
        $sql['query'] = $conn->query("SELECT nome, sigla, descricao, phone, ddd, logo_path, logo_footer_path, fb_link, tw_link, fl_link FROM empresa;");

        $empresa = $sql['query']->fetch(PDO::FETCH_ASSOC);

        unset($sql);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

// BUSCA FOTOS
if(!$msg_error){
    try {
        $sql = [];
        $sql['query'] = $conn->query("SELECT id, path, path_thumb, nome, descricao FROM fotos;");

        while($sql['dados'] = $sql['query']->fetch(PDO::FETCH_ASSOC)) {
            $fotos[] = $sql['dados'];
        }

        unset($sql);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

?>

<!doctype html>
<html lang="pt-BR">
<head>
    <title><?=$empresa['nome']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="/assets/jquery/jquery-3.4.1.min.js"></script>
    <style>        
        body{
            background-color: <?=$COLORS[0]?>;
            display: flex;
            justify-content: center;
            color: <?=$COLORS[2]?>;
            font-family: "Lucida Console", "Courier New", monospace;
        }
        
        .container{
            width: 65%;
        }
        
        header{
            display: flex;
            justify-content: space-between;
        }
        
        header p{
            align-self: center;
        }
        
        .topo-left{
            width: 30%;
        }
        
        .topo-right{
            text-align: right;
            width: 70%;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        
        
        .topo-right div{
            align-self: flex-end;
        }
        
        footer{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            text-align: justify;
            border-top: 1px solid <?=$COLORS[1]?>;
            padding-top: 1rem;
            margin-top: 2rem;
            font-family: "Andale Mono", "monospace";
        }
        
        .footer-top, .footer-top-desc{
            display: flex;
        }
        
        
        
        .footer-descricao{
            width: 500px;  padding: 0px 30px;
        }
        
        .footer-bottom{
            display: flex;
            width: 100%;
        }
        
        .footer-bottom p{
            margin-bottom: 0px;
            flex-grow: 1;
        }
        
        
        footer img{
            width: 140px;
            height: 120px;
            display: flex; 
            flex-wrap: wrap;
        }
        
        footer p{
            font-size: 14px;
        }
        
        footer h3{
            color: <?=$COLORS[3]?>;
            font-family: "Lucida Console", "Courier New", monospace;
            font-weight: normal;
            margin-top: 0px;
        }
        
        .pags{
            border-bottom: 1px solid #b3b3b3;
            text-align: right;
            padding-bottom: 10px;
            top: -20px;
            position: relative;
        }
        
        .imgs{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .imgs img{
            border-radius: 5px;
            height: 150px;
            width: 100%;
        }
        
        .img-box{
            width: 170px;
            margin: 20px 0px 20px 0px;
            cursor: pointer;
        }
        
        
        .img-box p{
            font-size: 14px;
        }
        
        
        /* SHADOW =============*/
        .social-links{
            text-align: left;
        }
        .social-links a{
            color: <?=$COLORS[3]?>;
            font-size: 16px;
            display: block;
            font-family: "Lucida Console", "Courier New", monospace;
            text-decoration: none !important;
            height: 22px;
            margin-bottom: 10px;
            display: flex;
        }
        .social-links img{
            height: 22px;
            width: 22px;
            margin-right: 5px;
            border-radius: 2px;
        }
        
        /* SHADOW =============*/
        .shadow {
            position: relative;
            height: 15px;
            width: 100%;
        }
        .shadow:before {
            position: absolute;
            content: '';
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            background-color: rgba(155,155,0, 0.25);
            border-radius: 50% / 20px; 
            box-shadow: rgba(0, 0, 0, 0.5) 0 5px 10px;
            clip: rect(20px, auto, 50px, 0);
        }
        
        .logo{
            width: 200px;
        }
        
        
        @media (max-width: 600px){
            
            .logo{
                width: 100%;
            }
            
            .pags{
                text-align: center;
                padding-top: 10px;
                position: inherit;
                top: inherit;
            }            
            
            .container{
                width: 100%;
            }
            
            .footer-top-desc img{
                width: 100%;
                height: auto;
            }
            
            .footer-bottom, .footer-top, .footer-top div{
                display: block !important;
            }
            
            .footer-bottom p{
                text-align: center;
                justify-content: center !important;
            }
            
            .footer-descricao{
                width: auto;  padding: 0px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="topo-left">
               <img class="logo" src="<?=$empresa['logo_path']?>"/>
            </div>
            
            <p><i class="fa fa-lg fa-phone" aria-hidden="true"></i> <?=$empresa['ddd'].' '.$empresa['phone']?></p>
        </header>
        
        <div class="pags">
            <?php
            for($i=1; $i <8; $i++){?>
               Página <?=$i?>
            <?php
            }?>
        </div>
        
        <section class="imgs">
            <?php
            if(is_array($fotos) && count($fotos)){
                foreach($fotos as $val){?>
                    <div class="img-box">
                        <img class="logo" data-foto="<?=$val['id']?>" alt="<?=$val['nome']?>" src="<?=$val['path_thumb']?>"/>
                        <p><?=$val['descricao']?></p>
                    </div>
                <?php
                }
            }?>
        </section>
        
        <footer>
            <div class="footer-top">
                <div class="footer-top-desc" style="display: flex;">
                    <img src="<?=$empresa['logo_footer_path']?>"/>
                    <div class="footer-descricao">
                        <?=$empresa['descricao']?>
                    </div>
                </div>
                <div class="social-links">
                    <h3>Acesse Também:</h3>
 
                    <?php
                    if(isset($empresa['fl_link']) && $empresa['fl_link']){?>
                        <a href="//<?=$empresa['fl_link']?>" target="_blank">
                            <img src="/assets/icons/facebook.png"/> <?=$empresa['fl_link']?></a>
                    <?php
                    }
                    
                    if(isset($empresa['fb_link']) && $empresa['fb_link']){?>
                        <a href="//<?=$empresa['fl_link']?>" target="_blank">
                            <img src="/assets/icons/twiter.png"/> <?=$empresa['fb_link']?></a>
                    <?php
                    }
                    
                    if(isset($empresa['tw_link']) && $empresa['tw_link']){?>
                        <a href="//<?=$empresa['fl_link']?>" target="_blank">
                            <img src="/assets/icons/flickr.png"/> <?=$empresa['tw_link']?></a>
                    <?php
                    }?>
                </div>
            </div>

            <div class="shadow"></div>
            <div class="footer-bottom">
                <p>Todos os direitos reservados - &copy; 2012</p>
                <p style="display: flex; justify-content: flex-end"><?=$empresa['sigla']?><span style="padding: 0px 5px">|</span> 
                <img class="logo" src="/layout01.png" style="height: 20px; width: 40px;">
                comunicação.com.br</p>
            </div>
        </footer>
    </div>
    <div class="load">
    </div>
    
    <script>
        $(function(){
            
            $('.img-box').on('click', function(){
                var foto = $(this).find('img').data('foto');
                
                $.ajax({
                    url: '/ajax/modal_img.php',
                    type: 'POST',
                    data: 'foto='+foto,
                    error: function() {
                        alert('O servidor não conseguiu processar o pedido!');
                    },
                    success: function(retorno) {
                        $('.load').html(retorno);
                        $('.load').css('display', 'flex');
                    }
                });
            });
        });
    </script>
</body>
</html>
