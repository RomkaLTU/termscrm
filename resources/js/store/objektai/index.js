const state = {
    markedVisited: [],
};

const getters = {
    getMarkedVisited: (state) => {
        return state.markedVisited;
    },
};

const mutations = {
    setMarketVisited(state,payload){
        if ( payload.state ) {
            // push checked value
            state.markedVisited.push(payload);
        } else {
            // remove unchecked ID
            state.markedVisited = state.markedVisited.filter( (obj) => {
                return obj.value !== payload.value;
            } );
        }
    },
};

const actions = {
    setMarketVisited({commit}, payload) {
        commit('setMarketVisited', payload);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}
