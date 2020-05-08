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

   /* Parâmetros de entrada */
   $file_id = isset($_POST['file_id']) ? (int)$Main->anti_injection($_POST['file_id']) : 0;
   $error   = '';
   $message = '';

   /* Validação de campos obrigatórios */
   /* Verifico se o campo file_id foi preenchido */
   if(empty($file_id)){

       $error++;
       $message .= $error. ' - O seguinte campo deve ser preenchido/selecionado <strong>file_id</strong>.<br/>';

   }

   if($error > 0){

       /** Preparo o formulario para retorno **/
       $result = array("cod"   => 0,
                       "msg"   => $message." < br /> Total de erros encontrados: ".$error,
                       "title" => "Atenção");

       /**pause*/
       sleep(1);

       /**Envio*/
       echo json_encode($result);

       /**Para o procedimento*/
       exit;

   }else{

       $Files->Delete($file_id)

       /** Result **/
       $result = array("cod"   => 1,
                       "msg"   => "Informações atualizadas com sucesso!",
                       "title" => "Atenção",
                       "qs"    => "TABLE=FILES&ACTION= DATAGRID");

       /** Pause **/
       sleep(1);

       /** Envio **/
       echo json_encode($result);

       /** Paro o procedimento **/
       exit;

   }

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
