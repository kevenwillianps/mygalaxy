<?php
try{

   /**
    * Created by MyCode
    * User: KEVEN
    * Date: 07/05/2020
    * Time: 20:35
   **/

   /** Parâmetros de entrada  **/
   $file_id = isset($_POST['file_id']) ? (int)$Main->anti_injection($_POST['file_id']) : 0;

   /** Instânciamento da classe Files  **/
   $Files = $Main->LoadClass('Files');

   /** Carrego o meu registro  **/
   $row = $Files->Get($file_id);

   /** Cabeçalho da página  **/
   $div  = '<div class="card text-white text-center shadow-sm border-0" style="background-image: linear-gradient(to right top,#3ac484,#51c28d,#64c094,#74be9c,#84bca2);">';
   $div .= '    <div class="card-body">';
   $div .= '        <h6 class="card-title">';
   $div .= '           Cadastro de:';
   $div .= '        </h6>';
   $div .= '        <h3 class="card-text">';
   $div .= '           Files';
   $div .= '        </h3>';
   $div .= '    </div>';
   $div .= '</div>';

   /** Link para voltar a listagem **/
   $div .= ' <div class="list-group mt-3">';
   $div .= '     <a href="#" class="list-group-item list-group-item-action" style="border-left: solid 4px #51c28d;" onclick="request('TABLE=FILES&ACTION=DATAGRID')">';
   $div .= '         <div class="d-flex w-100 justify-content-between">';
   $div .= '             <h6 class="mb-1">listagem de Files</h6>';
   $div .= '         </div>';
   $div .= '         <small class="text-muted">';
   $div .= '             Clique para abrir a listagem';
   $div .= '         </small>';
   $div .= '     </a>';
   $div .= ' </div>';

   /** Formulário de cadastro/atualização  **/
   $div .= '<div class="card mt-3">';
   $div .= '   <div class="card-body">';
   $div .= '       <form role="form" id="frmFiles">';
   $div .= '           <div class="row">';

   /** Monto meu campo 'file_id' **/
   $div .= '               <div class="col-md-12">';
   $div .= '                   <div class="form-group">';
   $div .= '	                    <label for="file_id">';
   $div .= '			                file_id';
   $div .= '			            </label>';
   $div .= '			            <input id="file_id" name="file_id" class="form-control" type="text" value="'.@utf8_encode($row->file_id).'" >';
   $div .= '	                </div>';
   $div .= '	            </div>';

   /** Monto meu campo 'name' **/
   $div .= '               <div class="col-md-12">';
   $div .= '                   <div class="form-group">';
   $div .= '	                    <label for="name">';
   $div .= '			                name';
   $div .= '			            </label>';
   $div .= '			            <input id="name" name="name" class="form-control" type="text" value="'.@utf8_encode($row->name).'" >';
   $div .= '	                </div>';
   $div .= '	            </div>';

   /** Monto meu campo 'path' **/
   $div .= '               <div class="col-md-12">';
   $div .= '                   <div class="form-group">';
   $div .= '	                    <label for="path">';
   $div .= '			                path';
   $div .= '			            </label>';
   $div .= '			            <input id="path" name="path" class="form-control" type="text" value="'.@utf8_encode($row->path).'" >';
   $div .= '	                </div>';
   $div .= '	            </div>';

   /** Monto meu campo 'date_register' **/
   $div .= '               <div class="col-md-12">';
   $div .= '                   <div class="form-group">';
   $div .= '	                    <label for="date_register">';
   $div .= '			                date_register';
   $div .= '			            </label>';
   $div .= '			            <input id="date_register" name="date_register" class="form-control" type="text" value="'.@utf8_encode($row->date_register).'" >';
   $div .= '	                </div>';
   $div .= '	            </div>';

   /** Monto meu campo 'date_update' **/
   $div .= '               <div class="col-md-12">';
   $div .= '                   <div class="form-group">';
   $div .= '	                    <label for="date_update">';
   $div .= '			                date_update';
   $div .= '			            </label>';
   $div .= '			            <input id="date_update" name="date_update" class="form-control" type="text" value="'.@utf8_encode($row->date_update).'" >';
   $div .= '	                </div>';
   $div .= '	            </div>';
   $div .= '           </div>';
   $div .= '       </form>';
   $div .= '   </div>';
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
