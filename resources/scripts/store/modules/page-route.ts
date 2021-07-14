import {ActionTree, GetterTree, MutationTree} from "vuex";

// @ts-ignore
import qs from "qs/dist/qs.js"


// initial state
const state = () => ({
	params: {},
	paramsDefault: {
		page: 1
	},
	pageActive: {
		title: '',
		path: ''
	},
})

// getters
const getters:GetterTree<any, any> = {}

// actions
const actions: ActionTree<any, any>  = {
	setup({dispatch}) {
		dispatch('setUrlParams');
		dispatch('setPageActive')
	},

	setPageActive({state, commit}) {
		let pageActive = {title: document.title, path: window.location.pathname};
		commit('setPageActive', pageActive)
	},

	setUrlParams({state, commit}) {
		let params = qs.parse(location.search,{ ignoreQueryPrefix: true });

		// convert string to array
		let prepared:any = {};
		for (let key in params) {
			if (key.includes('a_', 0)) {
				if (params[key]) {
					let updateKey = key.slice(2);
					prepared[updateKey] = params[key].split('-');
				}

			} else {
				prepared[key] = params[key]
			}
		}

		commit('setParams', prepared);
	},

	updatePath({state, commit, dispatch}, type) {
		let pageActive = state.pageActive;

        commit('clearParams')

        let params = state.params;

		let paramsStr = '';

		let prepared:any = {};
		// let params = state.params;

		// array to string
		for (let key in params) {
			if (typeof params[key] == "object") {
				if (Object.keys(params[key]).length) {
					prepared['a_' + key] = params[key].join('-');
				}
			} else if (params[key]) {
				prepared[key] = params[key];
			}
		}


		let paramsToStr = qs.stringify(prepared);

		if (paramsToStr) {
			paramsStr = `?${paramsToStr}`;
		}


		window.history.pushState(null, pageActive.title, pageActive.path + paramsStr);
	},

	updateParams({state, commit, dispatch}, object) {
		commit('setParams', {...state.params, ...object});
		dispatch('updatePath')
	},

	updateParamsDefault({state, commit}, object) {
		commit('setParamsDefault', {...state.paramsDefault, ...object})
	},


}

// mutations
const mutations: MutationTree<any> = {
	setParams(state, object) {
		state.params = object
	},

	setPageActive(state, object) {
		state.pageActive = object
	},

	setParamsDefault(state, object) {
		state.paramsDefault = object
	},

    clearParams(state){
        for (let key in state.paramsDefault) {
            if (typeof state.params[key] != "undefined" && state.params[key] === state.paramsDefault[key]) {
                delete state.params[key];
            }
        }
    }
}

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
