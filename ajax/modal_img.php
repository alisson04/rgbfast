<?php
require_once(__DIR__.'/../config/connection.php');

$foto = (int)$_POST['foto'];

// BUSCA FOTO
if(!$msg_error){
    try {
        $sql = [];
        
        $sql['stmt'] = $conn->prepare('SELECT path, descricao FROM fotos WHERE id = :id');
        $sql['stmt']->execute(array(
            ':id'   => $foto
        ));

        $foto = $sql['stmt']->fetch(PDO::FETCH_ASSOC);

        unset($sql);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}?>

<div class="modal">
    <h4><?=$foto['descricao']?></h4>
    <a href="#" onClick="$('.load').css('display', 'none');">Fechar</a>
        
    <img src="<?=$foto['path']?>" />
</div>  
        
<style>
    .modal{
        width: 50%;
        background-color: #FFF;
        padding: 20px;
        margin: 20px;
        border-radius: 10px;
        border: solid 1px #505050;
        text-align: center;
        position: relative;
    }
    
    .modal a{
        position: absolute;
        top: 10px;
        right: 20px;
    }
    
    .modal img{
        width: 80%;
        border-radius: 10px;
    }
    
    .load { 
        position: fixed;
        background-color: rgba(0,0,0,0.8);
        z-index: 5;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
            display: flex;
            justify-content: center;
            align-content: center;
    }

    .load modal{
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    @media (max-width: 600px){
        .modal{
            width: 90%;
        }
    }
</style>
