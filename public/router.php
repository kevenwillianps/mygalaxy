<?php

   /**
    * Created by MyCode
    * User: KEVEN
    * Date: 07/05/2020
    * Time: 20:35
   **/

   /** Instância da classe Main **/
   include_once ('lib/class/Main.class.php');

   /** Construtor **/
   $Main = new Main();

   /** Requisições **/
   $TABLE  = isset($_REQUEST['TABLE']) ? htmlspecialchars($_REQUEST['TABLE'])   : '';
   $ACTION = isset($_REQUEST['ACTION']) ? htmlspecialchars($_REQUEST['ACTION']) : '';

   /** Verifico a tabela **/
   switch ($TABLE)
   {

       /** Vejo minhas rotas disponíveis para a tabela 'FILES' **/
       case 'FILES':

           /** Rota para inserir/atualizar um registro **/
           if($ACTION == 'SAVE')
           {

               include('action/Files/files_save.php');

           }
           /** Rota para excluir um registro **/
           elseif($ACTION == 'DELETE')
           {

               include('action/Files/files_delete.php');

           }
           /** Rota para listar registros **/
           elseif($ACTION == 'DATAGRID')
           {

               include('action/Files/files_datagrid.php');

           }
           break;

   }
