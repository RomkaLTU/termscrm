const state = {
    markedDone: [],
};

const getters = {
    getMarkedDone: (state) => {
        return state.markedDone;
    },
};

const mutations = {
    setMarketDone(state,payload){
        if ( payload.state ) {
            // push checked value
            state.markedDone.push(payload);
        } else {
            // remove unchecked ID
            state.markedDone = state.markedDone.filter( (obj) => {
                return obj.value !== payload.value;
            } );
        }
    },
};

const actions = {
    setMarketDone({commit}, payload) {
        commit('setMarketDone', payload);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}
