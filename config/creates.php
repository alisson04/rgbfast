<?php
require_once('connection.php');

$conn->beginTransaction();

// TABELA EMPRESA
if(!$msg_error){
    try {
        $sql = [];
        $sql['query'] = "CREATE TABLE 
                            empresa (
                                id INT AUTO_INCREMENT NOT NULL,
                                nome VARCHAR(50),
                                sigla VARCHAR(20),
                                descricao TEXT ASCII,
                                phone VARCHAR(9),
                                ddd VARCHAR(2),
                                logo_path VARCHAR(100),
                                logo_footer_path VARCHAR(100),
                                fb_link VARCHAR(100),
                                tw_link VARCHAR(100),
                                fl_link VARCHAR(100),
                                PRIMARY KEY (id)
                            ) ENGINE = InnoDB ROW_FORMAT = DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
        $conn->exec($sql['query']);
        unset($sql['query']);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

// TABELA FOTOS
if(!$msg_error){
    try {
        $sql = [];
        $sql['query'] = "CREATE TABLE fotos (
                            id INT AUTO_INCREMENT NOT NULL,
                            path VARCHAR(200) NOT NULL,
                            path_thumb VARCHAR(200) NOT NULL,
                            nome VARCHAR(20),
                            descricao VARCHAR(200),
                            PRIMARY KEY (id)
                        ) ENGINE = InnoDB ROW_FORMAT = DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
        
        $conn->exec($sql['query']);
        unset($sql['query']);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

// INSERT EMPRESA
if(!$msg_error){
    
    try {
        $sql = [];
        $sql['query'] = "
                        INSERT INTO empresa 
                            (nome, sigla, descricao, phone, ddd, logo_path, logo_footer_path, fb_link, tw_link, fl_link)
                        VALUES
                            (:nome, :sigla, :descricao, :phone, :ddd, :logo_path, :logo_footer_path, :fb_link, :tw_link, :fl_link)";
        
        $sql['stmt'] = $conn->prepare($sql['query']);
        $sql['stmt']->execute(array(
            ':nome'     => 'RGB Fast',
            ':sigla'    => 'Linha Fast',
            ':descricao'=> '<h3>Pessoa ou Empresa</h3><p>Lorem ipsum dolor sit amet, lorem consectetur elit. Aliquam id mi ipsum sed ligula sollicitudin fermentum dolor.</p><p>Aliquam suscipit, massa quis posuere consecttur, enim libero tempor enim, ultriies est turpis nec risus. Nam in libero nulla, eu adipiscing nibh. In vitae massa vitae suscipit scelerisque lorem psum amed.</p>',
            ':phone'    => '0000-0000',
            ':ddd'      => '00',
            ':logo_path'=> '/imgs/logo.png',
            ':logo_footer_path' => '/imgs/logo_footer.jpg',
            ':fb_link'  => 'www.fb.com/loremipsum',
            ':tw_link'  => 'www.twitter.com/loremipsum',
            ':fl_link'  => 'www.flickr.com/loremipsum'
          ));

        unset($sql);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

// INSERT FOTOS
if(!$msg_error){
    
    try {
        $sql = [];
        
        for($i=1; $i<=20; $i++){
            $sql['values_stmt'][]               = "(:path_$i, :path_thumb_$i, :nome_$i, :descricao_$i)";
            $sql['values_in'][":path_$i"]       = "/imgs/galeria/foto_$i.jpg";
            $sql['values_in'][":path_thumb_$i"] = "/imgs_thumb/galeria/foto_$i.jpg";
            $sql['values_in'][":nome_$i"]       = "Foto $i";
            $sql['values_in'][":descricao_$i"]  = "Nome do Álbum Lorem Ipsum Dolor Amed";
        }
        
        $sql['query'] = "
                        INSERT INTO fotos 
                            (path, path_thumb, nome, descricao)
                        VALUES
                            ".implode(', ', $sql['values_stmt']);
        
        $sql['stmt'] = $conn->prepare($sql['query']);
        $sql['stmt']->execute($sql['values_in']);

        echo $sql['stmt']->rowCount();
        unset($sql);
    } catch(PDOException $e) {
        $msg_error = $e->getMessage();
    }
}

if(!$msg_error){
    $conn->commit();
}else{
    $conn->rollBack();
    echo $msg_error;
}

unset($conn);