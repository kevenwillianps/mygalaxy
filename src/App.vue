<template>

  <div id="app">

    <div class="container">

      <div class="row">

        <div class="card shadow-sm mt-3">

          <div class="card-body">

            <div class="row">

              <div class="col-md-12">

                <div class="media">

                  <img src="img/planet.png" class="mr-4" width="70px" alt="MyGalaxy">

                  <div class="media-body">

                    <h2 class="mt-0">

                      Bem vindo ao <strong> MyGalaxy!</strong>

                    </h2>

                    <p class="text-muted">

                      Envie seus arquivos para a <strong>galáxia</strong> e use o link para <strong>download</strong>!

                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-12 mt-3">

                <div class="file-drop-area">

                    <span class="fake-btn mr-3">

                      Escolha seus arquivos

                    </span>

                  <span class="file-msg">

                      Arraste seus arquivos e solte até aqui para carregalos

                    </span>

                  <input class="file-input" type="file" v-on:change="onChange">

                </div>

              </div>

            </div>

          </div>

          <div v-if="inputs.file && table.show">

            <div class="card-body">

              <div class="media">

                <img src="img/arrows.png" class="mr-3" alt="..." width="64px">

                <div class="media-body">

                  <h3 class="mt-0">

                    {{ inputs.name }}

                  </h3>

                  <div class="progress" style="height: 25px;">

                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:style="'width:' + table.progressBar + '%;'" v-bind:aria-valuenow="table.progressBar" aria-valuemin="0" aria-valuemax="100">

                      {{table.progressBar}}%

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="card-body border-top">

            <div class="row">

              <div class="col-md-12" v-if="table.show">

                <div class="form-group text-right">

                  <button class="btn btn-default btn-lg" v-on:click="PrepareForm">

                    <i class="fa fa-rocket"></i>

                    Enviar

                  </button>

                </div>

              </div>

              <div class="col-md-12" v-if="alert.show">

                <div class="alert alert-default" role="alert">

                  <h4 class="alert-heading">

                    Sucesso!

                  </h4>

                  <p>

                    Ooooowww yeah! Arquivos enviados com sucesso para <strong>galaxia</strong>! Utilize o link abaixo para realizar o download.

                  </p>

                  <hr>

                  <h4 class="mb-0">

                    <strong>Link:</strong> kevenwillian.com.br

                  </h4>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</template>

<script>

    import axios from 'axios';

    export default {

        name: 'App',

        data (){

            return{

                inputs : {

                    name      : null,
                    file      : null,
                    part      : null,
                    length    : 0,
                    count     : 0,
                    extension : null,

                },

                table : {

                    show        : false,
                    name        : null,
                    status      : null,
                    progressBar : 0,

                },

                alert : {

                    show : false,

                }

            }

        },

        methods: {

            async PrepareForm(){

                var string = this.inputs.file;
                var frase  = new Array();

                for (let i = 0; i < string.length ; i++) {

                    frase.push(string.charAt(i));

                }

                this.inputs.file   = frase;
                this.inputs.length = frase.length;

                for (let i = 0; i < this.inputs.length; i++){

                    await this.SendForm(this.inputs.name, i, frase[i], this.inputs.length, this.inputs.extension)

                        .then((response => {

                            this.CalculateProgressBar(i, this.inputs.length);
                            console.log(response.cod);

                        }));

                }

            },

            SendForm : async (name, pointer, part, length, extension) => {

                return axios.post('router.php?TABLE=FILES&ACTION=SAVE', {inputs: {name : name, pointer : pointer, part : part, length : length, extension : extension}});

            },

            /** Calculo a barra de progresso **/
            CalculateProgressBar(byteUploaded, length){

                this.table.progressBar = (byteUploaded*100) / length;

            },

            onChange(e) {

                /** Instâncimento de objeto para ler o conteúdo do arquivo ***/
                var fileReader = new FileReader();

                /** Leio o conteúdo do arquivo **/
                fileReader.readAsDataURL(e.target.files[0]);

                /** Pego o nome do arquivo **/
                this.inputs.name      = e.target.files[0].name;
                /** Pego o tipo do arquivo **/
                this.inputs.extension = e.target.files[0].type;

                fileReader.onload = (e) => {

                    /** Preencho o campo do arquivo **/
                    this.inputs.file = e.target.result;

                    /** Ativo a visualização da tabela de dados **/
                    this.table.show  = true;

                };

            },

        }

    }

</script>