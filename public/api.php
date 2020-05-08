<?php
    /**
     * Created by PhpStorm.
     * User: KEVEN
     * Date: 06/05/2020
     * Time: 21:44
     */

    /** Capturo meus campos envios por json **/
    $inputs    = json_decode(file_get_contents('php://input'), true);

    /** Parâmetros de entrada **/
    $file      = explode(',', $inputs['inputs']['file']);

    /** Pego a extensão do base64 **/
    $extension = explode('/', $inputs['inputs']['file']);
    $extension = explode(';', $extension[1]);
    $extension = $extension[0];

    /** Pego o ano atual **/
    $year  = date('Y');
    /** Pego o mês atual **/
    $month = date('m');
    /** Pego o dia atual **/
    $day   = date('d');
    /** Caminho raiz dos documentos **/
    $path  = "document/{$year}/{$month}/{$day}/{$extension}";
    /** Nome do arquivo **/
    $name  = 'MyGalaxy_'.rand(1, 10000);

    /** Verifico se existe o caminho **/
    if (is_dir($path)){

        /** Crio meu arquivo e escrevo dentro dele **/
        $document = fopen($path.'/'.$name.'.'.$extension, "wb");

        fwrite($document, base64_decode($file[1]));
        fclose($document);

    }else{

        /** Crio o caminho **/
        mkdir($path, 0777, true);

        /** Verifico se existe o caminho **/
        if (is_dir($path)){

            /** Crio meu arquivo e escrevo dentro dele **/
            $document = fopen($path.'/'.$name.'.'.$extension, "wb");

            fwrite($document, base64_decode($file[1]));
            fclose($document);

        }

    }