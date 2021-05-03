import common from '@/scripts/store/modules/common';
import catalog from '@/scripts/store/modules/catalog';


import {createStore} from 'vuex'

const strict: boolean = true

export default createStore({
    strict,
    modules: {
        common,
        catalog
    }
})
