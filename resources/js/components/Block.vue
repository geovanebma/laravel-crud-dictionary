<template>
    <div class="block">
        <div class="row alert-info2 gap0 pad0">
            <div class="col-md-1 gap0 pad0 div_word_check"><input type="checkbox" class="word_check" :name="'word_check'+item.id" :id="'word_check'+item.id" :value="item.id" :important="item.important" :learned="item.learned"></div>
            <div class="col-md-2 gap0 pad0 diagonal"><label class="regular_angle">{{ item.id }}</label></div>
            <div class="col-md-6 gap0 pad0 text-center">{{ item.word.replaceAll("'", "").toUpperCase()[0]+item.word.replaceAll("'", "").toLowerCase().substring(1)}}</div>
            <div class="col-md-3 gap0 pad0">
                <div class="icons_div">
                    <div class="diagonal2 col-md-3 gap0 pad0">
                        <i class="action_icons fa fa-play-circle inline" @click="falar(item.word)"></i>
                    </div>
                    <div class="diagonal2 col-md-3 gap0 pad0">
                        <i class="action_icons fa fa-exclamation-circle inline" :title="(item.important === true || item.important == '1' || item.important == 1)?'Important':'Don\'t important'" :class="(item.important === true || item.important == '1' || item.important == 1)?'important':'dont_important'" @click="important(item.id, item.important)"></i>
                    </div>
                    <div class="diagonal2 col-md-3 gap0 pad0">
                        <i class="action_icons fa fa-check-circle inline"  :title="(item.learned === true || item.learned == '1' || item.learned == 1)?'Learned':'Don\'t learned'" :class="(item.learned === true || item.learned == '1' || item.learned == 1)?'learned':'dont_learned'" @click="learned(item.id, item.learned)"></i>
                    </div>
                    <div class="diagonal2 col-md-3 gap0 pad0">
                        <i class="action_icons fa fa-sticky-note inline" @click="definition(item.id)"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="definitions" :id="'definition_'+item.id">
            <div v-for="(value, key) in item.definitions.split('*')">
                {{ value }}
            </div>
            <div class="definition_trad" :id="'definition_trad'+item.id">
                <!-- {{traduction(item.definitions, 'definition_trad'+item.id)}} -->
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['item', 'traduction', 'important', 'learned', 'falar', 'definition']
    }
</script>