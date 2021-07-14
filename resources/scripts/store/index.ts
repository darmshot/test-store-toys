// let {default: catalog} = await import( "@/scripts/store/modules/catalog");
// let {default: common} = await import( "@/scripts/store/modules/common");



import common from '@/scripts/store/modules/common';
import catalog from'@/scripts/store/modules/catalog'

import {createStore} from 'vuex'
import pageRoute from "@/scripts/store/modules/page-route";

const debug = process.env.NODE_ENV !== 'production'

const strict: boolean = debug

export default createStore({
    strict,
    modules: {
        common,
        catalog,
        pageRoute
    }
})


