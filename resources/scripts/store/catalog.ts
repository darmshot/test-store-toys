import common from '@/scripts/store/modules/common';
import catalog from '@/scripts/store/modules/catalog';
import pageRoute from '@/scripts/store/modules/page-route'

// import { InjectionKey } from 'vue'
import {createLogger, createStore, Store} from 'vuex'


const debug = process.env.NODE_ENV !== 'production'

// export const key: InjectionKey<Store<any>> = Symbol()

export default createStore <Store<any>>({
    strict: debug,
    plugins: debug ? [createLogger()] : [],
    modules: {
        common,
        catalog,
        pageRoute
    }
})
