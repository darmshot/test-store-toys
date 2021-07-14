<template>
    <div>
        <div v-if="title" class="h2 title-line"><span>{{ title }}</span><span class="title-line__line"></span></div>
        <div class="row">
            <div v-for="product in products" class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                <ProductThumbDefault :product="product"  />
            </div>
        </div>
    </div>

</template>

<script lang="ts">
import {computed, defineComponent} from "vue";
import { useStore} from "vuex";
import ProductThumbDefault from "@/scripts/components/ProductThumbDefault.vue"

let uuid = 0;

export default defineComponent({
    name: "Products",
    props: {
        title: {
            type: String,
            require: false
        },
        type: String,
        params: Object
    },
    components: {
        ProductThumbDefault
    },

    setup(props) {

        const store = useStore()

        const key = uuid.toString();

        uuid++

        let products = computed(() => store.state.catalog.products[key] ?? [])

        store.dispatch('catalog/loadProducts', {uuid: key, params: props.params, type: props.type})

        return {
            products,
            key,
        }
    },

})
</script>

<style scoped>

</style>
