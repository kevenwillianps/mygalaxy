<template>

  <div id="app">

    <div class="container">

      <div class="card shadow-sm mt-3">

        <div class="card-body">

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

          <div class="col-md-12 mt-3" v-if="!inputs.file">

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

          <div v-else>

            <div class="col-md-12 mt-3">

              <div class="media">

                <img src="img/arrows.png" class="align-self-center mr-3" alt="..." width="64px">

                <div class="media-body">

                  <h3 class="mt-0">

                    {{ inputs.name }}

                  </h3>

                  <div class="progress" style="height: 25px;" v-if="controls.progressBarAuxiliary">

                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                      100%

                    </div>

                  </div>

                  <div class="progress" style="height: 25px;" v-else-if="controls.progressBar > 0">

                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:style="'width:' + controls.progressBar + '%;'" v-bind:aria-valuenow="controls.progressBar" aria-valuemin="0" aria-valuemax="100">

                      {{controls.progressBar}}%

                    </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="col-md-12 mt-3">

              <div class="row">

                <div class="col-md-6">

                  <div class="form-group text-left">

                    <button class="btn btn-default btn-lg" v-on:click="ResetForm">

                      <i class="fa fa-close"></i>

                      Cancelar

                    </button>

                  </div>

                </div>

                <div class="col-md-6">

                  <div class="form-group text-right">

                    <button class="btn btn-default btn-lg" v-on:click="PrepareForm">

                      <i class="fa fa-rocket"></i>

                      Enviar

                    </button>

                  </div>

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
                    extension : null,

                },

                controls : {

                    show                 : false,
                    name                 : null,
                    status               : null,
                    progressBar          : 0,
                    progressBarAuxiliary : false,

                },

            }

        },

        methods: {

            /** Preparo o formulário para envio **/
            async PrepareForm(){

                /** Particionar o base64 em Array **/
                let localString = this.inputs.file;
                let start       = 0;
                let end         = 2097152;
                let localArray  = new Array();
                let part        = null;

                /** Executo de acordo com o tamanho do base64 **/
                for (let i = 0; i < localString.length; i++){

                    /** Preencho selecionando o que esta entre o valor inicial e final **/
                    part = localString.substring(start, end);

                    /** Verifico se cheguei ao final do base64, senão preencho as variáveis **/
                    if (part && part !== null){

                        localArray.push(part);

                        /** Crio um novo intervalo de valores **/
                        start = end;
                        end   = end + 2097152;

                    }

                }

                this.inputs.length = localString.length;

                /** Envio as requisições de acordo com o tamanho da array **/
                for (let i = 0; i < localArray.length; i++){

                    await this.SendForm(this.inputs.name, i, localArray[i], localArray.length, this.inputs.extension)

                        .then((response => {

                            this.CalculateProgressBar(i, (localArray.length - 1));
                            console.log(response.cod);

                        }));

                }

            },

            /** Envio uma requisição para o servidor **/
            SendForm : async (name, pointer, part, length, extension) => {

                return axios.post('router.php?TABLE=FILES&ACTION=SAVE', {inputs: {name : name, pointer : pointer, part : part, length : length, extension : extension}});

            },

            /** Calculo a barra de progresso **/
            CalculateProgressBar(byteUploaded, length){

                this.controls.progressBar = (byteUploaded * 100) / length;

            },

            ResetForm(){

                /** Lmpo minhas variaveis **/
                this.inputs.name          = null;
                this.inputs.file          = null;
                this.inputs.part          = null;
                this.inputs.length        = 0;
                this.inputs.extension     = null;
                this.controls.progressBar = 0;

            },

            onChange(e) {

                this.controls.progressBarAuxiliary = true;

                /** Lmpo minhas variaveis **/
                this.ResetForm();

                /** Instâncimento de objeto para ler o conteúdo do arquivo ***/
                var fileReader = new FileReader();

                /** Leio o conteúdo do arquivo **/
                fileReader.readAsDataURL(e.target.files[0]);

                /** Pego o nome do arquivo **/
                this.inputs.name      = e.target.files[0].name;
                /** Pego o tipo do arquivo **/
                this.inputs.extension = e.target.files[0].type;

                fileReader.onload = (e) => {

                    let base64 = e.target.result;

                    /** Preencho o campo do arquivo **/
                    this.inputs.file = base64.substring(base64.indexOf(",") + 1);

                    /** Ativo a visualização da tabela de dados **/
                    this.controls.show  = true;

                };

                this.controls.progressBarAuxiliary = false;

            },

        }

    }

</script>