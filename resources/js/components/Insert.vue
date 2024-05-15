<template>
  <div class="block">
      <!-- <div class="row alert alert-info">
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Word" v-model="$store.state.item.word"/>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Traduction" v-model="$store.state.item.traduction"/>
          </div>
          <div class="col-md-2">
            <select class="form-select" v-model="$store.state.item.type">
              <option value="">-- Type --</option>
              <option value="adjective">Adjective</option>
              <option value="adverb">Adverb</option>
              <option value="article">Article</option>
              <option value="conjuction">Conjuction</option>
              <option value="interjection">Interjection</option>
              <option value="noun">Noun</option>
              <option value="phrasal-verb">Phrasal-verb</option>
              <option value="preposition">Preposition</option>
              <option value="pronoun">Pronoun</option>
              <option value="verb">Verb</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="checkbox" class="form-check-input" id="learned" v-model="$store.state.item.learned"/>
            <label for="learned" class="form-check-label">Learned?</label>
            <input type="checkbox" class="form-check-input" id="important" v-model="$store.state.item.important"/>
            <label for="important" class="form-check-label">Important?</label>
          </div>
          <div class="col-md-1">
            <input type="button" class="btn btn-success" value="Insert" @click="insert()">
          </div>
      </div> -->
      <div class="row alert alert-info">
        <div class="mb-3">
          <label for="formFile" class="form-label">Inserir dados - Dictionary (.json)</label>
          <input class="form-control" type="file" name="insert_file" id="insert_file" accept=".json" @change="import_file">
        </div>
      </div>
      <div class="row alert alert-warning">
        <div class="mb-3">
          <label for="formFile" class="form-label">Inserir dados - Pharsal Verbs (.json)</label>
          <input class="form-control" type="file" name="insert_file2" id="insert_file2" accept=".json" @change="import_file2">
        </div>
      </div>
      <!-- <div class="row alert alert-primary">
        <div class="mb-3">
          <label for="formFile" class="form-label">ComparaÃÂ§ÃÂ£o</label>
          <input class="form-control" type="file" name="comparador" id="comparador" accept=".json, .txt" @change="comparador">
        </div>
      </div>
      <div class="row alert alert-secondary">
        <div class="mb-3">
          <label for="formFile" class="form-label">JunÃÂ§ÃÂ£o</label>
          <input class="form-control" type="file" name="juncao" id="juncao" accept=".json, .txt" @change="juncao">
        </div>
      </div> -->
      <!-- <input type="button" class="btn btn-success" value="Hora da mÃÂ¡gica" @click="magica"> -->
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        word: '',
        traduction: '',
        type: '',
        learned: false,
        important: false,
        jsonData:null,
        file:null,
        utterance:new SpeechSynthesisUtterance(),
        type_insert:"",
        most_used_words:[],
        big_list:[],
        big_list_complete:[],
      }
    },
    mounted(){
      // if(localStorage.getItem('dados')){
      //   this.insert()
      // }
    },
    methods: {
      changeTypeInsert:function(type_insert){
        this.type_insert = type_insert
      },
      getDate:function() {
        const date = new Date();
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hour = String(date.getHours()).padStart(2, '0');
        const minute = String(date.getMinutes()).padStart(2, '0');
        const second = String(date.getSeconds()).padStart(2, '0');
        const data_atual = `${year}-${month}-${day} ${hour}:${minute}:${second}`
        
        return data_atual;
      },
      insert:function() {
        // this.process(this.jsonData)
        var self = this
        var insert_array = []
        // var interval = setInterval(() => {

          // var cont = (localStorage.getItem('contador'))?parseInt(localStorage.getItem('contador')):0
          
          // if(cont == 10100){
          //   clearInterval(interval)
          //   return;
          // }
          
          // if(!localStorage.getItem('dados')){
            
            for (let i = 19900; i < 19999; i++) {
              var types = []
              var meanings = []
              var specifications = []
              
              for (let j = 0; j < self.jsonData[i].meanings.length; j++) {
                types.push(self.jsonData[i].meanings[j].type)
                meanings.push(self.jsonData[i].meanings[j].meaning)
                specifications.push(self.jsonData[i].meanings[j].specification.join('*'))
              }

              var insert_object = {
                word:        "'"+self.jsonData[i].word+"'",
                traduction:  "'"+(self.jsonData[i].traduction)?self.jsonData[i].traduction:""+"'",
                type:        "'"+types.join(", ")+"'",
                definitions: "'"+meanings.join("*")+"'",
                date_create: "'"+self.getDate()+"'",
                learned:     "'"+false+"'",
                important:   "'"+false+"'",
                order:       "'"+self.jsonData[i].most_used_position+"'"
              }

              insert_array.push(insert_object)
            }

            axios.post('/api/dictionary', insert_array).then(response => {
              console.log(response);
            }).catch((error) => {
              console.log(error);
            })

            // localStorage.setItem('dados', JSON.stringify(insert_array));

            // var new_cont = parseInt(cont+100)
            // localStorage.setItem('contador', new_cont);
            // location.reload()
          // }else{
          //   self.jsonData = (self.jsonData)?self.jsonData:JSON.parse(localStorage.getItem('dados'))
            
          //   if(JSON.parse(localStorage.getItem('dados'))){
          //     for (let i = cont; i < cont+100; i++) {
          //       var insert_object = {
          //         word:self.jsonData[i].word,
          //         traduction:(self.jsonData[i].traduction)?self.jsonData[i].traduction:"",
          //         type:self.jsonData[i].type,
          //         definitions:(self.jsonData[i].definitions)?self.jsonData[i].definitions.join("Â¢"):"",
          //         date_create:self.getDate(),
          //         learned:self.jsonData[i].learned,
          //         important:self.jsonData[i].important,
          //         order:self.jsonData[i].order
          //       }
          //     }
          //   }else{
          //     for (let i = cont; i < cont+100; i++) {
          //       var insert_object = {
          //         word:self.jsonData[i].word,
          //         traduction:(self.jsonData[i].traduction)?self.jsonData[i].traduction:"",
          //         type:types.join(", "),
          //         definitions:meanings.join("Â¢"),
          //         date_create:self.getDate(),
          //         learned:false,
          //         important:false,
          //         order:self.jsonData[i].most_used_position
          //       }
          //     }
          //   }

            // insert_array.push(insert_object)
            // console.log(insert_array)

            // axios.post('/api/dictionary', insert_array).then(response => {
            //   // var new_cont = parseInt(cont+100)
            //   // localStorage.setItem('contador', new_cont);
            //   console.log(response)
            //   // location.reload()
            // }).catch((error) => {
            //   console.log(error);
            // })
          // }
  
        // }, 10000);

        // axios.post('/api/dictionary', insert_array).then(response => {
        //   console.log(response);
        // }).catch((error) => {
        //   console.log(error);
        // })
      },
      insert2:function() {
        var insert_array = []
        for (let i = 0; i < 100; i++) {
          var descriptions = this.jsonData[i][1].descriptions
          var derivatives =  this.jsonData[i][1].derivatives 
          var examples =     this.jsonData[i][1].examples    
          var synonyms =     this.jsonData[i][1].synonyms    

          if(descriptions){
            descriptions = descriptions.join("Â¢")
          }

          if(derivatives){
            derivatives = derivatives.join("Â¢")
          }

          if(examples){
            examples = examples.join("Â¢")
          }

          if(synonyms){
            synonyms = synonyms.join("Â¢")
          }
         
          var insert_object = {
            word:        "'"+this.jsonData[i][0]+"'",
            traduction:  "'"+descriptions+"'",
            derivatives: "'"+derivatives+"'",
            examples:    "'"+examples+"'",
            synonyms:    "'"+synonyms+"'",
            date_create: "'"+this.getDate()+"'",
            learned:     "'"+false+"'",
            important:   "'"+false+"'",
            order:       "'"+i+"'"
          }

          insert_array.push(insert_object)
        }

        axios.post('/api/phrasal_verbs', insert_array).then(response => {
          console.log(response);
        }).catch((error) => {
          console.log(error);
        })
      },
      import_file:function(event){
        this.file = event.target.files[0];

        if (!this.file) {
          return;
        }

        const reader = new FileReader();

        reader.onload = () => {
          try {
            this.jsonData = JSON.parse(reader.result);
            this.insert()
          } catch (error) {
            console.log('Erro ao processar o JSON:', error);
          }
        };

        reader.readAsText(this.file);
      },
      import_file2:function(event){
        this.file = event.target.files[0];

        if (!this.file) {
          return;
        }

        const reader = new FileReader();

        reader.onload = () => {
          try {
            const array = [...Object.entries(JSON.parse(reader.result))];
            this.jsonData = array;
            // console.log(this.jsonData, this.jsonData.length)
            this.insert2()
          } catch (error) {
            console.log('Erro ao processar o JSON:', error);
          }
        };

        reader.readAsText(this.file);
      },
      comparador:function(event){
        var self = this
        this.file = event.target.files[0];

        if (!this.file) {
          return;
        }

        const reader = new FileReader();

        reader.onload = () => {
          const conteudo = reader.result;
          const linhas = conteudo.split('\n');
          self.most_used_words = linhas;
        };

        reader.readAsText(this.file);
      },
      juncao:function(event){
        var self = this
        this.file = event.target.files[0];

        if (!this.file) {
          return;
        }

        const reader = new FileReader();

        reader.onload = () => {
          try {
            const array = [...Object.entries(JSON.parse(reader.result))];
            this.jsonData = array;

            self.big_list = this.jsonData
          } catch (error) {
            console.log('Erro ao processar o JSON:', error);
          }

        };

        reader.readAsText(this.file);
      },
      magica:function(){
        var most_used_words = this.most_used_words
        var big_list = this.big_list
        var big_list_complete = this.big_list_complete
        var data = []

        for (let i = 0; i < most_used_words.length; i++) {
          const element = most_used_words[i];
          var new_object = [
                            i,
                            [
                              element.toLowerCase(),
                              {
                                "MEANINGS": {
                                  "1": [
                                    "Type",
                                    "Meaning",
                                    [
                                      "Specification"
                                    ]
                                  ],
                                },
                                "ANTONYMS": [],
                                "SYNONYMS": []
                              }
                            ]
                          ]

          data.push(new_object)

          for (let j = 0; j < big_list.length; j++) {
            if(element.toLowerCase() == big_list[j][1][0].toLowerCase()){
              big_list[j][0] = i
              data[i] = big_list[j]
            }
          }
        }

        for (let i = 0; i < data.length; i++) {
          const element = data[i];
          var meanings = []

          for (const [key, item] of Object.entries(element[1][1].MEANINGS)) {
            if(i == 4){
              console.log(item, key)
            }

            meanings.push({'type':item[0],'meaning':item[1],'specification':item[2]})
          }

          // element[1][1].MEANINGS.map((item, index) => {
          // });

          var ob = {
            word:element[1][0],
            meanings:meanings,
            most_used_position:element[0],
            examples:""
          }
          
          big_list_complete.push(ob)
        }
      }
    }
  }
</script>