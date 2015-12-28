<?php

define('INCLUDE_CHECK',1);

//if(!$_POST['img']) die("erro img");

//$img=mysql_real_escape_string(end(explode('/',$_POST['img'])));

//$row=mysql_fetch_assoc(mysql_query("SELECT * FROM internet_shop WHERE img='".$img."'"));

//if(!$row) die("erro img");

echo '<strong>'.'NOME'.'</strong>

<p class="descr">'.'DESCRICAO'.'</p>

<strong>Valor: R$ '.'PRECO'.'</strong>
<small>Arraste para o carrinho</small><br />
<small><a href="">Mais Informações</a></small>';
?>
