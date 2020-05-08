<?php
/*
 * Classe de conexão ao banco de dados MySql
 * @filesource
 * @autor		Kenio de Souza
 * @copyright	Copyright 2010 Serenity Informatica
 * @package		class
 * @subpackage	class.class
 * @version		1.0
 */
class Connect
{
    //Configurações de acesso ao banco de dados
    var $Server   = SERVER;
    var $Database = DATABASE;
    var $User     = USER;
    var $Password = PASS;
    var $Conn     = 0;
    var $Query    = 0;
    var $Error    = "";
    var $message  = array();

    //Construtor
    function __construct(){}

    //Função responsável em retornar as devidas mensagens de erros.
    function Halt($msg)
    {

        /**Preparo o formulario para retorno*/
        $result = array("cod"         => 3,
                        "message_sql" => $message[0] = array($msg .";" . $this->Error),
                        "title"       =>"Atenção");

        /**pause*/
        sleep(1);

        /**Envio*/
        echo json_encode($result);

        /**Para o procedimento*/
        exit;

    }

    //Função que efetua a conexão com o banco de dados
    function Connect()
    {
        //Verifico se não há nenhuma conexão em aberto. Caso não exista conexão em aberto efetuo uma nova conexão
        if(empty($this->Conn))
        {
            //Crio o objeto de conexão com o banco de dados
            $this->Conn = @mysqli_connect($this->Server, $this->User, $this->Password, $this->Database);

            //Verifico se a conexão
            if (!$this->Conn)
            {
                //Retorna uma string descrevendo o ultimo erro da função connect
                $this->Error = @mysqli_connect_error();

                //Trato a mesagem de erro
                $this->Halt("Falha na Canexão! ");
            }
        }
    }

    //Executo uma consulta SQL no bano de dados
    function ExecuteQuery($query)
    {
        //Caso seja um valor nulo
        $query = str_replace("''", "NULL", $query);

        //Efetuo uma conexão ao banco de dados Mysql
        $this->Connect();

        //Efetuo uma consulta SQL no banco de dados Mysql
        $this->Query = @mysqli_query($this->Conn, $query);

        //Verifico se à conulta retornou algum erro
        if (!$this->Query)
        {
            //Retorna uma string descrevendo o ultimo erro
            $this->Error = @mysqli_error($this->Conn);

            //Trato a mesagem de erro
            $this->Halt("Consulta SQL inválida! ".$query);
        }

        //Retorno a consulta SQL
        return $this->Query;
    }

    //Retorna a linha atual do conjunto de resultados como um objeto
    function query_fetch_object()
    {
        return @mysqli_fetch_object($this->Query);
    }

    //Retorna a linha atual do conjunto de resultados como um objeto
    function query_fetch_assoc()
    {
        return @mysqli_fetch_assoc($this->Query);
    }

    //Retorna a linha atual do conjunto de resultados como uma array
    function query_fetch_array()
    {
        return @mysqli_fetch_array($this->Query);
    }

    //Retorna a linha atual do conjunto de resultados como um json
    function query_fetch_json()
    {
        return json_encode(@mysqli_fetch_array($this->Query));
    }

    //Obtém uma linha do resultado como uma matriz numerada
    function query_fetch_row()
    {
        return @mysqli_fetch_row($this->Query);
    }

    //Retorno o número de linhas de uma consulta SQL
    function query_num_row()
    {
        return @mysqli_num_rows($this->Query);
    }

    //Retorna o id gerado automaticamente na última consulta
    function insert_id()
    {
        return @mysqli_insert_id($this->Query);
    }

    //Libera a memória associada ao resultado
    function free_result()
    {
        if(!empty($this->Query))
            mysqli_free_result($this->Query);
    }

    //Fecha uma conexão aberta anteriormente com o banco de dados
    function close()
    {
        if(!empty($this->Conn))
            mysqli_close($this->Conn);
    }

    //Destrutor
    function __destruct(){

        if(!empty($this->Query))
            @mysqli_free_result($this->Query);

        if(!empty($this->Conn))
            @mysqli_close($this->Conn);

    }

}