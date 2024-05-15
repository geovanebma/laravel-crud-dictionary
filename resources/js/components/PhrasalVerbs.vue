<template>
  <div class="block">
    <div id="words" v-if="data.length > 0">
      <div id="form_div" class="row">
        <div class="col-md-5">
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
            <input class="form-check-input" type="checkbox" value="" id="important_filter" v-model="important_filter">
            <label class="form-check-label" for="important_filter">
              Important
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="learned_filter" v-model="learned_filter">
            <label class="form-check-label" for="learned_filter">
              Learned
            </label>
          </div>
        </div>
      </div>
      <div v-for="(item, index) in data">
        <block-component :item="item" :falar="falar" :traduction="traduction" :important="important" :learned="learned" :definition="definition"></block-component>
      </div>
      <div id="paginator_div">
        <div class="col-md-12">
          <button class="pag" @click="previousPage" :disabled="current_page === 1">Anterior</button>
          <button class="pag" v-for="page in page_range" :key="page" @click="changePage(page)" :class="{ active: page === current_page }">{{ page }}</button>
          <button class="pag" @click="nextPage" :disabled="current_page === total_pages">Próxima</button>
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
        important_filter:false,
        learned_filter:false,
        link:'/api/phrasal_verbs'
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
            important: this.important_filter,
            learned: this.learned_filter,
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
              current_data.push(response.data[i]);
            }
  
            this.data = current_data
            this.total = response.data.length
            var count_pages = this.total_pages
            this.total_pages = Math.trunc((this.total%100 == 0)?this.total/100:this.total/100+1)
  
            if(count_pages == 0){
              this.calculatepage_range();
            }
  
            console.log(this.data)
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
            console.log(response.data.learned, response.data.date_learned)
        }).catch((error) => {
            console.log(error)
        });
        this.busca()
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
      important_filter(newValue) {
        console.log(newValue)
        this.busca();
      },
      learned_filter(newValue) {
        console.log(newValue)
        this.busca();
      }
    }
  }
</script>