<template>

  <div id="app">

    <div class="container">

      <div class="row mx-auto">

        <div class="offset-1 col-md-9">

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

              <div class="table-responsive">

                <table class="table align-items-center table-flush">

                  <thead class="thead-light">

                    <tr>

                      <th scope="col">Nome</th>
                      <th scope="col">Status</th>
                      <th scope="col">Andamento</th>
                      <th scope="col"></th>

                    </tr>

                  </thead>

                  <tbody>

                    <tr>

                      <td>

                        {{ table.name }}

                      </td>

                      <td>

                        {{ table.status }}

                      </td>

                      <td>

                        <div class="d-flex align-items-center">

                          <span class="mr-2">

                            60%

                          </span>

                          <div>

                            <div class="progress">

                              <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>

                            </div>

                          </div>

                        </div>

                      </td>

                    </tr>

                  </tbody>

                </table>

              </div>

            </div>

            <div class="card-body border-top">

              <div class="row">

                <div class="col-md-12" v-if="table.show">

                  <div class="form-group text-right">

                    <button class="btn btn-default btn-lg" v-on:click="submitForm">

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

  </div>

</template>

<script>

    import axios from 'axios';

    export default {

        name: 'App',
        data (){

            return{

                inputs : {

                    name : null,
                    file : null,
                    base64Array : [],

                },

                table : {

                    show   : false,
                    name   : null,
                    status : null,

                },

                alert : {

                    show : false,

                }

            }

        },

        methods: {

            submitForm(){

                var string = this.inputs.file;
                var frase  = new Array();

                for (let i = 0; i < string.length ; i++) {

                    frase.push(string.charAt(i));

                }

                this.inputs.base64Array = frase;

                for(let i = 0; i < 10; i++){

                    axios.post('router.php?TABLE=FILES&ACTION=SAVE', {inputs: this.inputs})

                        .then(response => {

                            this.table.show = false;
                            this.alert.show = true;

                            console.log('Sucesso:' + response.data.cod)

                        })

                        .catch(response => {

                            console.log('Erro:' + response.data.cod)

                        });

                }

            },

            onChange(e) {

                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0]);

                /** Coloco o nome do arquivo na tabela **/
                this.inputs.name = e.target.files[0].name;

                fileReader.onload = (e) => {

                    /** Preencho o campo do arquivo **/
                    this.inputs.file = e.target.result;
                    this.table.show = true;

                }

            },

        }

    }

</script>