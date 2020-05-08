<?php
try{

   /**
    * Created by MyCode
    * User: KEVEN
    * Date: 07/05/2020
    * Time: 20:35
   **/

   /** Capturo meus campos envios por json **/
   $inputs    = json_decode(file_get_contents('php://input'), true);

   /** Instânciamento da classe Files  **/
   $Files     = $Main->LoadClass('Files');

   /** Parâmetros de entrada **/
   $file_id   = isset($inputs['inputs']['file_id']) ? (int)$Main->anti_injection($inputs['inputs']['file_id'])    : 0;
   $file      = isset($inputs['inputs']['file'])    ? explode(',', $inputs['inputs']['file'])            : '';
   $name      = isset($inputs['inputs']['name'])    ? (string)$Main->anti_injection($inputs['inputs']['name'])    : '';
   $part      = isset($inputs['inputs']['part'])    ? (string)$Main->anti_injection($inputs['inputs']['part'])    : '';
   $pointer   = isset($inputs['inputs']['pointer']) ? (string)$Main->anti_injection($inputs['inputs']['pointer']) : '';

   /** Pego a extensão do base64 **/
   $extension = explode('/', isset($inputs['inputs']['file']) ? (string)$Main->anti_injection($inputs['inputs']['file']) : '');
   $extension = explode(';', $extension[1]);
   $extension = $extension[0];

   /** Pego o ano atual **/
   $year      = date('Y');
   /** Pego o mês atual **/
   $month     = date('m');
   /** Pego o dia atual **/
   $day       = date('d');
   /** Caminho raiz dos documentos **/
   $path      = "document/{$year}/{$month}/{$day}/{$extension}";

   /** Controle de erros **/
   $error     = 0;
   $message   = array();

   /** Validação de campos obrigatórios **/
   /** Verifico se o campo file_id foi preenchido **/
   if($file_id < 0){

       $error++;
       $message[0] = $error. ' - O seguinte campo deve ser preenchido/selecionado <strong>file_id</strong>.<br/>';

   }
   /** Verifico se o campo name foi preenchido **/
   if(empty($name)){

       $error++;
       $message[1] = $error. ' - O seguinte campo deve ser preenchido/selecionado <strong>name</strong>.<br/>';

   }
   /** Verifico se o campo path foi preenchido **/
   if(empty($path)){

       $error++;
       $message[2] = $error. ' - O seguinte campo deve ser preenchido/selecionado <strong>path</strong>.<br/>';

   }

    if($error > 0){

       /** Preparo o formulario para retorno **/
       $result = array("cod" => 0, "msg" => $message);

       /**pause*/
       sleep(1);

       /**Envio*/
       echo json_encode($result);

       /**Para o procedimento*/
       exit;

   }else{

       /** Verifico se existe o caminho **/
       if (is_dir($path)){

           if (strcmp($pointer, 'true' == 0)){

               /** Crio meu arquivo e escrevo dentro dele **/
               $document = fopen($path.'/'.rand(1,10000).$name, "wb");

               /** Escrevo dentro do arquivo **/
//           fwrite($document, base64_decode($file[1]));
               fwrite($document, $part);

               /** Encerro a escrita do arquivo **/
               fclose($document);

           }else{

               /** Result **/
               $result = array("cod" => 0, "msg" => "Não foi possível criar o arquivo");

               /** Pause **/
               sleep(1);

               /** Envio **/
               echo json_encode($result);

               /** Paro o procedimento **/
               exit;

           }

           if (is_file($path.'/'.$name)){

               /** Método para salvar o registro **/
               $Files->Save($file_id, $name, $path);

               /** Result **/
               $result = array("cod" => 1, "msg" => "Arquivo salvo com sucesso!");

               /** Pause **/
               sleep(1);

               /** Envio **/
               echo json_encode($result);

               /** Paro o procedimento **/
               exit;

           }else{

               /** Result **/
               $result = array("cod" => 0, "msg" => "Não foi possível criar o arquivo");

               /** Pause **/
               sleep(1);

               /** Envio **/
               echo json_encode($result);

               /** Paro o procedimento **/
               exit;

           }

       }else{

           /** Crio o caminho **/
           mkdir($path, 0777, true);

           /** Verifico se existe o caminho **/
           if (is_dir($path)){

               /** Crio meu arquivo e escrevo dentro dele **/
               $document = fopen($path.'/'.rand(1,10000).$name, "wb");

               /** Escrevo dentro do arquivo **/
//               fwrite($document, base64_decode($file[1]));
               fwrite($document, $part);

               /** Encerro a escrita do arquivo **/
               fclose($document);

               if (is_file($path.'/'.$name)){

                   /** Método para salvar o registro **/
                   $Files->Save($file_id, $name, $path);

                   /** Result **/
                   $result = array("cod" => 1, "msg" => "Arquivo salvo com sucesso!");

                   /** Pause **/
                   sleep(1);

                   /** Envio **/
                   echo json_encode($result);

                   /** Paro o procedimento **/
                   exit;

               }else{

                   /** Result **/
                   $result = array("cod" => 0, "msg" => "Não foi possível criar o arquivo");

                   /** Pause **/
                   sleep(1);

                   /** Envio **/
                   echo json_encode($result);

                   /** Paro o procedimento **/
                   exit;

               }

           }

       }

   }

}catch(Exception $e){

   /** Preparo o formulario para retorno **/
   $result = array("cod"   => 0, "msg"   => $e->getMessage(), "title" => "Atenção");

   /** Pause **/
   sleep(1);

   /** Envio **/
   echo json_encode($result);

   /** Paro o procedimento **/
   exit;

}
