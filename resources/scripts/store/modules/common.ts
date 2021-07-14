// initial state
import {ActionTree, GetterTree, MutationTree} from "vuex";
import axiosInstance from "@/scripts/modules/axios-instance";
import { ElNotification } from 'element-plus';

const state = () => ({
    headerDropdown: false,
    window: {
        width: 0,
        height: 0
    },
    breakpoint: null,
    breakpoints: {
        xs: 576,
        sm: 768,
        md: 992,
        lg: 1200,
        xl: 1400,
    },
    searchData: [],

    cartData: [],
    cartMeta: {}
})

// getters
const getters: GetterTree<any, any> = {
    vue(state) {
        return this._vm
    }
}

// actions
const actions: ActionTree<any, any> = {
    setup({dispatch}) {
        dispatch('loadCart')
    },

    // -------------------------------------------------------------
    //   search
    // -------------------------------------------------------------
    loadSearchAutocomplete({commit, rootState}, queryString) {
        return new Promise((resolve, reject) => {
            axiosInstance.post(`/api/search?q=${queryString}`).then(response => {
                commit('setSearchData', response.data.data)
                resolve(response.data.data)
            }).catch((e) => {
                console.log(e.text)
            })
        })
    },

    // -------------------------------------------------------------
    //   header
    // -------------------------------------------------------------
    handleHeaderDropdown({commit}) {
        commit('changeHeaderDropdown')
    },

    // -------------------------------------------------------------
    //   resize
    // -------------------------------------------------------------
    handleResize({commit, state}, object) {
        commit('setWindow', {width: object.width, height: object.height})

        let breakpoint = 'xxl'

        for (let breakpointKey in state.breakpoints) {
            if (state.breakpoints[breakpointKey] > object.width) {
                breakpoint = breakpointKey
                break;
            }
        }

        commit('setBreakpoint', breakpoint)
    },

    // -------------------------------------------------------------
    //   cart
    // -------------------------------------------------------------
    loadCart({commit}) {
        axiosInstance.post('/cart').then(responce => {
            console.log(responce.data)
            commit('setCartData', responce.data.data)
            commit('setCartMeta', responce.data.meta)
        })
    },

    handleAddProductToCart({state, dispatch}, object) {

        axiosInstance.post('/cart/add', object).then(response => {
            dispatch('loadCart')

            if (typeof response.data.success != "undefined") {
                dispatch('loadCart')
                dispatch('notification', {title: 'Корзина', success: response.data.success})
            } else if (typeof response.data.error != "undefined") {
                if (typeof response.data.error.option != "undefined") {
                    let options = '';

                    for (let gettersKey in response.data.error.option) {
                        options += '<p>' + response.data.error.option[gettersKey] + '</p>'
                    }

                    dispatch('notification', {error: options})
                }
            }
        })
    },

    handleRemoveProductFromCart({state, commit, dispatch}, key) {
        axiosInstance.post('/cart/remove', {product_id: key}).then(response => {
            if (typeof response.data.success != "undefined") {
                // let products = state.cartData.filter((item: { cart_id: any; }) => item.cart_id !== key);
                //
                // let cart = state.cart;
                // commit('setCartData',products)
                //
                // commit('setCart', {
                //     ...cart,
                //     products: products,
                //     quantity: response.data.quantity,
                //     total: response.data.total
                // });
                dispatch('loadCart')

                dispatch('notification', {title: 'Корзина', success: response.data.success})
            } else if (typeof response.data.error != "undefined") {

            }
        })
    },

    // -------------------------------------------------------------
    //   notification
    // -------------------------------------------------------------
    notification({getters}, object) {
        if (typeof object.success != 'undefined') {
            ElNotification({
                title: object.title,
                type: 'success',
                dangerouslyUseHTMLString: true,
                position: 'bottom-right',
                message: object.success
            });
        } else if (typeof object.warning != 'undefined') {
            getters.vue.$notify({
                showClose: true,
                dangerouslyUseHTMLString: true,
                message: object.warning,
                type: 'warning'
            })
        } else if (typeof object.error != 'undefined') {
            getters.vue.$notify({
                showClose: true,
                dangerouslyUseHTMLString: true,
                message: object.error,
                type: 'error'
            })
        }
    }
}

// mutations
const mutations: MutationTree<any> = {
    changeHeaderDropdown(state) {
        state.headerDropdown = !state.headerDropdown
    },

    setWindow(state, object) {
        state.window = object
    },

    setBreakpoint(state, string) {
        state.breakpoint = string
    },

    setSearchData(state, array) {
        state.searchData = array
    },


    // -------------------------------------------------------------
    //   cart
    // -------------------------------------------------------------
    setCartData(state, array) {
        state.cartData = array
    },

    setCartMeta(state, object) {
        state.cartMeta = object
    }

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
