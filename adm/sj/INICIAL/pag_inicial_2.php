<?php if (getIdUsuario() == 1): ?>
<div class="panel panel-default">
  <div class="panel-heading">Menu Rápido</div>
  <table class="table table-bordered">
    <tr>
      <th>Grupos</th>
      <th>Assunto</th>
      <th>Tópicos</th>
      <th>Artigos</th>
      <th>Fotos</th>
    </tr>
    <tr>
      <td>
        <a href="/adm/sj/index.php?op=cad_grup">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=lis_grup">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_assunto">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=lista_assunto">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_top">Adicionar</a> | 
       <a href="/adm/sj/index.php?op=list_top">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_art">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=list_art">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_galer">Adicionar</a>
        <a href="/adm/sj/index.php?op=list_galer">Listar</a></td>
   </tr>
    <tr>
      <th>Vídeos</th>
      <th>Eventos</th>
      <th>Comunicados</th>
      <th>Livros</th>
      <th>Usuários</th>
    </tr>
    <tr>
      <td>
        <a href="/adm/sj/index.php?op=cria_galeria_video">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=lista_galeria_video">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_event">Adicionar</a> | 
       <a href="/adm/sj/index.php?op=list_event">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_comu">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=list_comu">Listar</a></td>
     <td>
        <a href="/adm/sj/index.php?op=cad_livro">Adicionar</a> | 
        <a href="/adm/sj/index.php?op=lista_livros">Listar</a></td>
      <td>
        <a href="/adm/sj/index.php?op=cad_usu">Adicionar</a> | 
       <a href="/adm/sj/index.php?op=lis_usu">Listar</a></td>
    </tr>
  </table>
</div>
<?php endif; ?>