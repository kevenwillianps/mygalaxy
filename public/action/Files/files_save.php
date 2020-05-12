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
   $file_id   = isset($inputs['inputs']['file_id'])   ? (int)$Main->anti_injection($inputs['inputs']['file_id'])      : 0;
   $name      = isset($inputs['inputs']['name'])      ? (string)$Main->anti_injection($inputs['inputs']['name'])      : '';
   $pointer   = isset($inputs['inputs']['pointer'])   ? (int)$Main->anti_injection($inputs['inputs']['pointer'])      : 0;
   $part      = isset($inputs['inputs']['part'])      ? (string)$Main->anti_injection($inputs['inputs']['part'])      : '';
   $length    = isset($inputs['inputs']['length'])    ? (int)$Main->anti_injection($inputs['inputs']['length'])       : 0;
   $extension = isset($inputs['inputs']['extension']) ? (string)$Main->anti_injection($inputs['inputs']['extension']) : '';

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
       $message[0] = $error. 'file_id - O seguinte campo deve ser preenchido/selecionado';

   }
   /** Verifico se o campo name foi preenchido **/
   if(empty($name)){

       $error++;
       $message[1] = $error. 'name - O seguinte campo deve ser preenchido/selecionadop';

   }
   /** Verifico se o campo path foi preenchido **/
   if($pointer < 0){

       $error++;
       $message[2] = $error. 'pointer - O seguinte campo deve ser preenchido/selecionado';

   }
   /** Verifico se o campo path foi preenchido **/
   if(empty($part)){

       $error++;
       $message[3] = $error. 'part - O seguinte campo deve ser preenchido/selecionado';

   }
   /** Verifico se o campo path foi preenchido **/
   if($length < 0){

       $error++;
       $message[4] = $error. 'length - O seguinte campo deve ser preenchido/selecionado';

   }
   /** Verifico se o campo path foi preenchido **/
   if(empty($extension)){

        $error++;
        $message[5] = $error. 'extension - O seguinte campo deve ser preenchido/selecionado';

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

           if ($pointer == ($length - 1)){

               /** Pego o conteúdo do arquivo **/
               $file    = file_get_contents($path.'/'.$name);

               /** Decodifico o base64 do arquivo **/
               $content = substr($file, (strpos($file, ',') + 1));

               if (!empty($content)){

                   /** Crio meu arquivo e escrevo dentro dele **/
                   $document = fopen($path.'/'.$name, "w+");

                   /** Escrevo dentro do arquivo **/
                   fwrite($document, base64_decode($content));

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
                       $result = array("cod" => 0, "msg" => "Não foi possível salvar o arquivo");

                       /** Pause **/
                       sleep(1);

                       /** Envio **/
                       echo json_encode($result);

                       /** Paro o procedimento **/
                       exit;

                   }

               }else{

                   /** Result **/
                   $result = array("cod" => 0, "msg" => "Não foi possível localizar o arquivo");

                   /** Pause **/
                   sleep(1);

                   /** Envio **/
                   echo json_encode($result);

                   /** Paro o procedimento **/
                   exit;

               }

           }else{

               /** Crio meu arquivo e escrevo dentro dele **/
               $document = fopen($path.'/'.$name, "a+");

               /** Escrevo dentro do arquivo **/
               fwrite($document, $part);

               /** Encerro a escrita do arquivo **/
               fclose($document);

               if (is_file($path.'/'.$name)){

                   /** Result **/
                   $result = array("cod" => 1, "msg" => "Arquivo criado com sucesso");

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

       }else{

           /** Crio o caminho **/
           mkdir($path, 0777, true);

           /** Verifico se existe o caminho **/
           if (is_dir($path)){

               if ($pointer == ($length - 1)){

                   /** Pego o conteúdo do arquivo **/
                   $file    = file_get_contents($path.'/'.$name);

                   /** Decodifico o base64 do arquivo **/
                   $content = substr($file, (strpos($file, ',') + 1));

                   if (!empty($content)){

                       /** Crio meu arquivo e escrevo dentro dele **/
                       $document = fopen($path.'/'.$name, "w+");

                       /** Escrevo dentro do arquivo **/
                       fwrite($document, base64_decode($content));

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
                           $result = array("cod" => 0, "msg" => "Não foi possível salvar o arquivo");

                           /** Pause **/
                           sleep(1);

                           /** Envio **/
                           echo json_encode($result);

                           /** Paro o procedimento **/
                           exit;

                       }

                   }else{

                       /** Result **/
                       $result = array("cod" => 0, "msg" => "Não foi possível localizar o arquivo");

                       /** Pause **/
                       sleep(1);

                       /** Envio **/
                       echo json_encode($result);

                       /** Paro o procedimento **/
                       exit;

                   }

               }else{

                   /** Crio meu arquivo e escrevo dentro dele **/
                   $document = fopen($path.'/'.$name, "a+");

                   /** Escrevo dentro do arquivo **/
                   fwrite($document, $part);

                   /** Encerro a escrita do arquivo **/
                   fclose($document);

                   if (is_file($path.'/'.$name)){

                       /** Result **/
                       $result = array("cod" => 1, "msg" => "Arquivo criado com sucesso");

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
