// let {default: catalog} = await import( "@/scripts/store/modules/catalog");
// let {default: common} = await import( "@/scripts/store/modules/common");



import common from '@/scripts/store/modules/common';


import {createStore} from 'vuex'

const strict: boolean = true

export default createStore({
    strict,
    modules: {
        common
    }
})


