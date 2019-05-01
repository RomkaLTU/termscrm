import Vue from 'vue'
import Vuex from 'vuex'
import objektai from './objektai'
import tasks from './tasks'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        objektai,
        tasks
    },
});
