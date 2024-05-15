<template>
  <div class="block">
    <div id="words" v-if="data.length > 0">
      <div id="form_div" class="row">
        <div class="col-md-3">
          <input type="text" name="find" id="find" class="form-control" aria-describedby="basic-addon2" placeholder=" Find..." v-model="word">
          <i class="fa fa-search" id="search"></i>
        </div>
        <div class="col-md-3">
          <select class="form-select" id="select_type" v-model="type">
            <option value="" selected>-- Type --</option>
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
        <div class="col-md-4">
          <div class="form-check">
            <select class="form-select" name="filter" id="filter" v-model="filter">
              <option value="" checked>-- Select --</option>
              <option value="important_filter">Important</option>
              <option value="dont_important_filter">Don't Important</option>
              <option value="learned_filter">Learned</option>
              <option value="dont_learned_filter">Don't Learned</option>
            </select>
            <!-- <input class="form-check-input" type="checkbox" value="" id="important_filter" v-model="important_filter">
            <label class="form-check-label" for="important_filter">
              Important
            </label> -->
          </div>
          <!-- <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="learned_filter" v-model="learned_filter">
            <label class="form-check-label" for="learned_filter">
              Learned
            </label>
          </div> -->
        </div>
        <div class="col-md-2">
          <i class="action_icons2 fa fa-exclamation-circle inline" title="Check as important!" @click="check_as_important()"></i>
          <i class="action_icons2 fa fa-check-circle inline"       title="Check as learned!"   @click="check_as_learned()"  ></i>
        </div>
      </div>
      <div v-for="(item, index) in data">
        <block-component :item="item" :falar="falar" :traduction="traduction" :important="important" :learned="learned" :definition="definition"></block-component>
      </div>
      <div id="paginator_div">
        <div class="col-md-12">
          <button class="pag" @click="previousPage" :disabled="current_page === 1">Anterior</button>
          <button class="pag" v-for="page in page_range" :key="page" @click="changePage(page)" :class="{ active: page === current_page }">{{ page }}</button>
          <button class="pag" @click="nextPage" :disabled="current_page === total_pages">PrÃ³xima</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        data:[],
        data_list:null,
        utterance:new SpeechSynthesisUtterance(),
        important_val:false,
        learned_val:false,
        total:113375,
        current_page:1,
        page_range:[],
        total_pages:0,
        word:"",
        type:"",
        filter:"dont_learned_filter",
        important_filter:false,
        learned_filter:false,
        link:'/api/dictionary'
      }
    },
    mounted(){
      this.utterance["lang"] = "en-US"
      this.busca()
    },
    methods: {
      busca:function() {
        axios.get(this.link, {
          params: {
            word: this.word,
            type: this.type,
            filter: this.filter,
          }
        })
        .then(response => {
          if(response.data.length > 0){
            if((response.data.length < 100 && response.data.length != 0)){
              this.current_page = 1
              this.total_pages = 1
              this.calculatepage_range();
            }

            var current_page = this.current_page
            var current_data = []
            var cont = (response.data.length > 100)?current_page*100:response.data.length

            for (let i = current_page*100-100; i < cont; i++) {
              response.data[i].definitions = response.data[i].definitions.replaceAll("'", "").replaceAll("ï¿½", "*")
              current_data.push(response.data[i]);
            }
  
            this.data = current_data
            this.total = response.data.length
            var count_pages = this.total_pages
            this.total_pages = Math.trunc((this.total%100 == 0)?this.total/100:this.total/100+1)
  
            if(count_pages == 0){
              this.calculatepage_range();
            }
          }
        })
        .catch(error => {
          console.log(error)
        });
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
      setTextmessage:function(text, name){
        this.utterance.text = text
    
        if(name){
            setVoice(name)
        }
      },
      speakText:function(){
        speechSynthesis.speak(this.utterance)
      },
      falar:function(text){
        text = text.replace("'", "")
        this.setTextmessage(text)
        this.speakText()
      },
      traduction: function(phase, id, mode){
        var t = translate(phase, { to: "pt" });
        var text = ""

        t.then(function(a){
          if(mode){
            text = a.split(",,")[0].split(" ")[0]
          }else{
            text = a
          }
          $("#"+id).text(text)
        })
      },
      traduction2: function(phase, id){
        var t = translate(phase, { to: "pt" });
        var text = ""

        t.then(function(a){
          text = a
          $("#"+id).text(text)
        })
      },
      learned:function(key, learned) {
        learned = (learned == true)?false:true
        var date_learned = (learned == true)?this.getDate():"";

        axios.patch('/api/dictionary/' + key, {"learned":learned, "date_learned":date_learned}).then(response => {
            // console.log(response.data.learned, response.data.date_learned)
        }).catch((error) => {
            console.log(error)
        });
        this.busca()
      },
      check_as_learned:function(){
        var word_check = $(".word_check")
        var date_learned = this.getDate();
        var keys = []

        for (let i = 0; i < word_check.length; i++) {
          const element = word_check[i].checked;
          
          if(element){
            // console.log(word_check[i].getAttribute('learned'), word_check[i].getAttribute('learned').length, typeof word_check[i].getAttribute('learned'))
            keys.push({id:word_check[i].value, learned:(word_check[i].getAttribute('learned') == 'false')?'true':'false', date_learned:date_learned})
          }
        }

        console.log(keys)

        if(keys.length){
          axios.patch('/api/dictionary/', keys).then(response => {
              console.log(response)
          }).catch((error) => {
              console.log(error)
          });

          this.busca()
        }else{
          alert("Atenção, não há nenhum item selecionado, favor verificar!")
          this.busca()
        }

      },
      important:function(key, important) {
        important = (important == true)?false:true

        axios.patch('/api/dictionary/' + key, {"important":important}).then(response => {
            console.log(response.data.important)
        }).catch((error) => {
            console.log(error)
        });
        this.busca()
      },
      check_as_important:function(){
        axios.patch('/api/dictionary/' + keys, {"important":important}).then(response => {
            console.log(response.data.important)
        }).catch((error) => {
            console.log(error)
        });
        this.busca()
      },
      definition:function(id){
        $("#definition_"+id).toggle()
      },
      changePage:function(page) {
        this.current_page = page;
        this.calculatepage_range();

        this.busca();
      },
      calculatepage_range:function() {
        const total_pages = this.total_pages;
        const current_page = this.current_page;
        const rangeStart = Math.max(1, current_page - 3);
        const rangeEnd = Math.min(current_page + 3, total_pages);
        this.page_range = [];

        for (let i = rangeStart; i <= rangeEnd; i++) {
          this.page_range.push(i);
        }
      },
      previousPage:function() {
        if (this.current_page > 1) {
          this.changePage(this.current_page - 1);
        }
      },
      nextPage:function() {
        if (this.current_page < this.total_pages) {
          this.changePage(this.current_page + 1);
        }
      }
    },
    watch: {
      filter(newValue) {
        this.busca();
      }
    }
  }
</script>