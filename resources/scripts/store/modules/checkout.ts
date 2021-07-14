// initial state
import {ActionTree, GetterTree, MutationTree} from "vuex";
import axiosInstance from "@/scripts/modules/axios-instance";
import {ElNotification} from 'element-plus';

const state = () => ({
    loading: false
})

// getters
const getters: GetterTree<any, any> = {}

// actions
const actions: ActionTree<any, any> = {
    handleConfirm({state, dispatch}, object) {
        // state.loading = true

        axiosInstance.post('/checkout/confirm', object).then(response => {
            if (typeof response.data.success != "undefined") {
                console.log('i herher')
                window.location.replace("/checkout/success")
            }

            // state.loading = false
        })
    },
}

// mutations
const mutations: MutationTree<any> = {}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
