<?php
    $scripts[] = "/adm/sj/js/message_audio.js";
    $scripts[] = "/adm/sj/js/recordmp3.js";
?>
<div class="page-header title-article">
    <h2>Mensagens</h2>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-chevron-down"></span>
            </button>
            <ul class="dropdown-menu slidedown">
                <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-refresh">
                </span>Refresh</a></li>
                <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-ok-sign">
                </span>Available</a></li>
                <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-remove">
                </span>Busy</a></li>
                <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-time"></span>
                    Away</a></li>
                <li class="divider"></li>
                <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-off"></span>
                    Sign Out</a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <ul class="chat">
            <li class="left clearfix"><span class="chat-img pull-left">
                <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                        dolor, quis ullamcorper ligula sodales.
                    </p>
                </div>
            </li>
            <li class="right clearfix"><span class="chat-img pull-right">
                <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>13 mins ago</small>
                        <strong class="pull-right primary-font">Bhaumik Patel</strong>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                        dolor, quis ullamcorper ligula sodales.
                    </p>
                </div>
            </li>
            <li class="left clearfix"><span class="chat-img pull-left">
                <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span>14 mins ago</small>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                        dolor, quis ullamcorper ligula sodales.
                    </p>
                </div>
            </li>
            <li class="right clearfix"><span class="chat-img pull-right">
                <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>15 mins ago</small>
                        <strong class="pull-right primary-font">Bhaumik Patel</strong>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                        dolor, quis ullamcorper ligula sodales.
                    </p>
                </div>
            </li>
        </ul>
    </div>
    <div class="panel-footer">
        <div class="btn-group">
            <button class="btn btn-danger" onclick="startRecording(this);">
                <span class="glyphicon glyphicon-record"></span>
                Gravar Voz
            </button>
            <button class="btn btn-warning" onclick="stopRecording(this);" disabled>
                <span class="glyphicon glyphicon-stop"></span>
                Parar de Gravar
            </button>
        </div>
        <div id="response"></div>
        <ul id="recordingslist" class="list-group"></ul>

        <br>
        <br>

        <div class="input-group">
            <input id="message-description" type="text" class="form-control input-lg" placeholder="Digite sua mensagem aqui ..." />
            <span class="input-group-btn">
                <button class="btn btn-warning btn-lg" id="btn-chat" onclick="sendMenssage();">Enviar</button>
            </span>
        </div>
    </div>
</div>

