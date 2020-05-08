<?php
try{

   /**
    * Created by MyCode
    * User: KEVEN
    * Date: 07/05/2020
    * Time: 20:35
   **/

   /* Instânciamento da classe Files  */
   $Files = $Main->LoadClass('Files');

   /* Campos */
   $quantity = $Files->Count();

   /* Verifico se existe registros no banco de dados */
   if($quantity <= 0){

       $div = '<div class="alert alert-info">';
       $div.= '    <ul>';
       $div.= '        <li>';
       $div.= '            <strong>Atenção!</strong> Nenhum conteúdo cadastrado';
       $div.= '        </li>';
       $div.= '    </ul>';
       $div.= '</div>';

   }

   /* Link para atualizar a listagem */
   $div  = '<a href="#" class="card text-white text-center shadow-sm border-0 text-decoration-none" onclick="request('TABLE=FILES&ACTION=DATAGRID')" style="background-image:linear-gradient(to right top,#3ac484,#51c28d,#64c094,#74be9c,#84bca2);">';
   $div .= '    <div class="card-body">';
   $div .= '        <h6 class="card-title">';
   $div .= '            Clique para atualizar';
   $div .= '        </h6>';
   $div .= '        <h5 class="card-title">';
   $div .= '            Conteúdos Cadastrados';
   $div .= '        </h5>';
   $div .= '        <h3 class="card-text">';
   $div .= '            <strong>';
   $div .=                 $quantity;
   $div .= '            </strong>';
   $div .= '        </h3>';
   $div .= '    </div>';
   $div .= '</a>';

   /* Link para abrir o formulário */
   $div .= ' <div class="list-group mt-3">';
   $div .= '     <a href="#" class="list-group-item list-group-item-action" style="border-left: solid 4px #51c28d;" onclick="request('TABLE=FILES&ACTION=FORM')">';
   $div .= '         <div class="d-flex w-100 justify-content-between">';
   $div .= '             <h6 class="mb-1">Cadastrar Nova Postagem</h6>';
   $div .= '         </div>';
   $div .= '         <small class="text-muted">';
   $div .= '             Clique para abrir o formulário';
   $div .= '         </small>';
   $div .= '     </a>';
   $div .= ' </div>';

   /* Cabeçalho da minha tabela */
   $div .= '<div class="bg-primary mt-3 shadow-sm">';
   $div .= '    <table class="table table-bordered table-hover">';
   $div .= '        <thead>';
   $div .= '            <tr>';
   $div .= '                <th>';
   $div .= '                   file_id';
   $div .= '                </th>';
   $div .= '                <th>';
   $div .= '                   name';
   $div .= '                </th>';
   $div .= '                <th>';
   $div .= '                   path';
   $div .= '                </th>';
   $div .= '                <th>';
   $div .= '                   date_register';
   $div .= '                </th>';
   $div .= '                <th>';
   $div .= '                   date_update';
   $div .= '                </th>';
   $div .= '            </tr>';
   $div .= '        </thead>';
   $div .= '    <tbody>';
   /* Chamo o método que traz todos os registros */
   $Files->All();
   while($rowFiles = $Files->FetchObject()){

       $div .= '              <tr id="row-'.$row->content_id.'">';
       $div .= '                <td>';
       $div .=                     utf8_encode($rowFiles->file_id);
       $div .= '                </td>';
       $div .= '                <td>';
       $div .=                     utf8_encode($rowFiles->name);
       $div .= '                </td>';
       $div .= '                <td>';
       $div .=                     utf8_encode($rowFiles->path);
       $div .= '                </td>';
       $div .= '                <td>';
       $div .=                     utf8_encode($rowFiles->date_register);
       $div .= '                </td>';
       $div .= '                <td>';
       $div .=                     utf8_encode($rowFiles->date_update);
       $div .= '                </td>';
       $div .= '              </tr>';

   }
   $div .= '    </tbody>';
   $div .= '    </table>';
   $div .= '</div>';

   /** Result **/
   $result = array("cod"   => 1,
                   "msg"   => "Datagrid montada com sucesso!",
                   "title" => "Atenção");

   /** Pause **/
   sleep(1);

   /** Envio **/
   echo json_encode($result);

   /** Paro o procedimento **/
   exit;

}catch(Exception $e){

   /** Preparo o formulario para retorno **/
   $result = array("cod"   => 0,
                   "msg"   => $e->getMessage(),
                   "title" => "Atenção");

   /** Pause **/
   sleep(1);

   /** Envio **/
   echo json_encode($result);

   /** Paro o procedimento **/
   exit;

}
