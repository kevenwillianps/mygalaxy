<?php

   /**
    * Created by MyCode
    * User: KEVEN
    * Date: 07/05/2020
    * Time: 20:35
   **/

   /** Configuração de acesso ao banco de dados **/
   require_once("lib/class/Host.php");

   /** Classe de conexão ao banco de dados Mysql **/
   require_once("lib/class/Mysql.class.php");

   class Files
   {

       /** Construtor da classe **/
       function __construct()
       {

           /** Cria o objeto de conexão com o banco de dados **/
           $this->obj = new Connect;

       }

       /** Lista um registro específico **/
       public function Get($file_id)
       {

           /** Parâmetro de entrada **/
           $this->file_id = (int)$file_id;

           /** Consulta SQL **/
           $sql = "select * from files where file_id = {$this->file_id}";

           /** Executo o comando SQL **/
           $this->obj->ExecuteQuery($sql);

           /** Retorno em forma de objeto uma consulta SQL **/
           return $this->obj->query_fetch_object();

       }

       /** Lista todos os registros **/
       public function All()
       {

           /** Consulta SQL **/
           $sql = "select * from files";

           /** Executo o comando SQL **/
           $this->obj->ExecuteQuery($sql);

       }

       /** Insere/autualiza um registro no banco de dados **/
       public function Save($file_id, $name, $path)
       {

           /** Parâmetros de entrada **/
           $this->file_id = (int)$file_id;
           $this->name    = (string)$name;
           $this->path    = (string)$path;

           /** Verifico se é inserção ou atualização **/
           if($this->file_id == 0)
           {

               /** Consulta SQL **/
               $sql = "INSERT INTO files(`file_id`, `name`, `path`)VALUES('{$this->file_id}', '{$this->name}', '{$this->path}')";

           }else
           {

               /** Consulta SQL **/
               $sql = "UPDATE files SET `file_id` = {$this->file_id}, `name` = '{$this->name}', `path` = '{$this->path}' WHERE `file_id` = {$this->file_id}";

           }

           /** Executo o comando SQL **/
           $this->obj->ExecuteQuery($sql);

       }

       /** Excluo um registro específico **/
       public function Delete($file_id)
       {

           /** Parâmetro de entrada **/
           $this->file_id = (int)$file_id;

           /** Consulta SQL **/
           $sql = "DELETE FROMfiles WHERE file_id = {$this->file_id}";

           /** Executo o comando SQL **/
           if($this->obj->ExecuteQuery($sql))
           {

               return true;

           }else
           {

               return false;

           }

       }

       /** Retorno o número de linhas de uma consulta SQL **/
       function NumRow()
       {

           return $this->obj->query_num_row();

       }

       /** Libera a memória associada ao resultado **/
       function FreeResult()
       {

           $this->obj->free_result();

       }

       /** Retorna a linha atual do conjunto de resultados como um objeto **/
       function FetchObject()
       {

           return $this->obj->query_fetch_object();

       }

       /** Fecha uma conexão aberta anteriormente com o banco de dados **/
       function __destruct()
       {

           $this->obj->close();

       }

   }
