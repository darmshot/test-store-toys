// initial state
import {ActionTree, GetterTree, MutationTree, Store} from 'vuex';
import axiosInstance from "@/scripts/modules/axios-instance";

const state = () => ({
    loadingPage: false,
    productGallery: {},
    products: {},
    productRoute: '',
    productData: [],
    productMeta: {},
    productParamsDefault: {
        limit: '20',
        page: 1,
        order: 'asc',
        sort: 'title'
    },
    productShows: [
        {label: '20', value: '20'}, {label: '24', value: '24'}, {label: '50', value: '50'}
    ],
    productSorts: [
        {
            label: 'По умолчанию', value: 'title:asc'
        },
        {
            label: 'Название (Я - А)', value: 'title:desc'
        },
        {
            label: 'Цена (низкая > высокая)', value: 'price:asc'
        },
        {
            label: 'Цена (высокая > низкая)', value: 'price:desc'
        }
    ],
})

// getters
const getters: GetterTree<any, any> = {
    productSortActiveInfo: (state, getters, rootState) => {
        let sort = rootState.pageRoute.params.sort ?? state.productParamsDefault.sort;
        let order = rootState.pageRoute.params.order ?? state.productParamsDefault.order;

        let id = `${sort}:${order}`;

        return state.productSorts.find((sort: { value: string; }) => sort.value === id)
    },

    productShowActiveInfo: (state, getters, rootState) => {
        let id = rootState.pageRoute.params.limit ?? state.productParamsDefault.limit;

        return state.productShows.find((show: { value: string; }) => show.value === id)
    },

    productSize: (state, getters, rootState) => {
        return Number(rootState.pageRoute.params.limit ?? state.productParamsDefault.limit);
    },

    productPage: (state, getters, rootState) => {
        return Number(rootState.pageRoute.params.page ?? state.productParamsDefault.page);
    },

    isStartPage: (state) => {
        return state.productMeta.current_page === 1
    },

    isEndPage: (state) => {
        return ((state.productMeta.total / state.productMeta.per_page) < state.productMeta.current_page)
    }

}

// actions
const actions: ActionTree<any, any> = {
    setup({state, commit, dispatch}, object) {

        if (typeof object.productRoute != "undefined") {
            dispatch('pageRoute/updateParamsDefault', state.productParamsDefault, {root: true})
            commit('setProductRoute', object.productRoute)
            dispatch('loadPageProducts')
        }else if(typeof object.productGallery) {
            commit('setProductGallery',object.productGallery)
        }
    },

    loadProducts({commit, state}, object) {
        axiosInstance.post('/api/catalog/products', {
            ...object.params,
            type: object.type
        }).then(response => {
            commit('setProducts', {uuid: object.uuid, products: response.data.data})
        })
    },

    loadProductGallery({commit, state}, id) {
        axiosInstance.post(`/api/catalog/products/${id}/gallery`)
    },

    loadPageProducts({state, commit, rootState}) {
        commit('setLoadingPage', true)

        axiosInstance.post(state.productRoute, rootState.pageRoute.params).then(response => {
            commit('setProductData', response.data.data)
            commit('setProductMeta', response.data.meta)
            commit('setLoadingPage', false)
        }).catch((e)=>{
            console.log(e.text)
            commit('setLoadingPage', false)
        })
    },

    handleProductPage({dispatch}, page) {
        dispatch('pageRoute/updateParams', {page: page}, {root: true})
        dispatch('loadPageProducts');
    },

    handleProductShow({dispatch}, show) {
        dispatch('pageRoute/updateParams', {limit: show}, {root: true})
        dispatch('loadPageProducts');
    },

    handleProductSort({dispatch}, object) {
        dispatch('pageRoute/updateParams', {
            sort: object.sort,
            order: object.order
        }, {root: true})

        dispatch('loadPageProducts');
    }
}

// mutations
const mutations: MutationTree<any> = {
    setLoadingPage(state, bool) {
        state.loadingPage = bool;
    },

    setProducts(state, object) {
        state.products[object.uuid] = object.products
    },

    setProductRoute(state, string) {
        state.productRoute = string;
    },

    setProductData(state, array) {
        state.productData = array
    },

    setProductMeta(state, object) {
        state.productMeta = object
    },

    setProductGallery(state, object) {
        state.productGallery = object
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
