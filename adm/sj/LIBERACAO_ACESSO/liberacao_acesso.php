<?php if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<div class="box left box-w756px">

	<div class="box-esp">

		<div class="tit-azul"> Lista de Usuários </div>

		<div class="h20px"></div>

		<div class="box-content">

			<table class="table table-striped">
				<tr>
					<th width="50">ID</th>
					<th>NOME</th>
					<th width="50">PERMISSÕES</th>
				</tr>

			    <?php
        			$sql = mysql_query("SELECT * FROM grupos ORDER BY nome");

        			while($ln = mysql_fetch_array($sql))
        			{
                        if(++$i != 2)
                        {
                            echo '<tr class="tr-linha1">';
                        }
                        else
                        {
                            echo '<tr class="tr-linha2">';
                            $i = 0;                            
                        }
    			?>
							<td><?=$ln['id'];?></td>
							<td><?=$ln['nome'];?></td>
							<td>
                                <?php
                                    if ($id <> '1')
                                    {
                                ?>
										<a href="index.php?op=modu_acess&op1=<?=$ln['id'];?>" title="Ver/Editar">
											<img src="images/i_edit.png" alt="Alterar" border="0" />
										</a>
					            <?php
                                    }
                                ?>
							</td>
			  			</tr>
			    <?php
			        }
			    ?>
			</table>

		</div>

	</div>

</div>
