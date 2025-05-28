<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="box box-w200px box-mR20px left">

	<div class="box-esp">
		<div class="tit-azul">
			Menu
		</div>
		
		<div class="clear h10px"></div>

        <nav>
        	<dl> 
        		<li class="link"><a href="index.php">Início</a></li>
                <?php

                    if($_SESSION['login'][$_SESSION['login']['tipo']]['id_usuarios'] == 2)
                    {
                        $res = mysql_query("SELECT * FROM menu WHERE id = 1 ORDER BY ordem ASC");    
                    }
                    else
                    {
                        $res = mysql_query("SELECT * FROM menu ORDER BY ordem ASC");    
                    }

                    while ($ln = mysql_fetch_assoc($res))
                    {
                        $id_menu	     = $ln['id'];	
                        $res_descricao	 = $ln['descricao'];

                        $res1            = mysql_query("SELECT * FROM sub_menu WHERE id_menu = '$id_menu' AND bloquiado != '0' ORDER BY descricao ASC");

                        if(mysql_num_rows($res1))
                        {
                ?>
                            <dt><a href=""><?=$res_descricao;?></a></dt>
                            <dd>
                            	<ul>                    
                <?php
                                while ($rowsubmenu 	= mysql_fetch_assoc($res1))
                                {
                                    $sub_descricao	= $rowsubmenu['descricao'];
                                    $link			= $rowsubmenu['link'];
                ?>
                                	<li><a href="<?=$link;?>"><?=$sub_descricao;?></a></li>
                <?php
                                }
                ?>
                            	</ul>
                            </dd>
                <?php
                        }
                    }//FECHO
                ?>	
        		<li class="link"><a href="sair_sistema.php"><img src="/adm/sj/images/sair.png" style="margin: 0 3px -2px 0; width: 13px;">Sair</a></li>
            </dl>
        
        </nav>

	</div>

</div>

<div class="clear h20px"></div>