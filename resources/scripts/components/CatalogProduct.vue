<template>
<div>
    <CatalogProductNav/>
    <div class="row">
        <div v-for="product in productData" :key="product.id" class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
            <ProductThumbDefault :product="product"/>
        </div>
    </div>
    <el-pagination
        background
        class="mb-4"
        layout="prev, pager, next"
        :page-size="productMeta.per_page"
        :pager-count="5"
        :current-page="productMeta.current_page"
        :total="productMeta.total"
        @current-change="handlePage"
        hide-on-single-page
    >
    </el-pagination>
</div>
</template>

<script lang="ts">
import {useStore} from "vuex";
import {computed, defineComponent} from "vue";
import ProductThumbDefault from "@/scripts/components/ProductThumbDefault.vue"
import CatalogProductNav from "@/scripts/components/CatalogProductNav.vue"

export default defineComponent({
    name: "CatalogProduct",
    components: {
        ProductThumbDefault,
        CatalogProductNav
    },
    setup() {
        const store = useStore()

        const productData = computed(() => store.state.catalog.productData)
        const productMeta = computed(() => store.state.catalog.productMeta)

        return {
            productData,
            productMeta
        }
    },
    methods: {
        scrollToElement() {
            const el = document.getElementById('app');

            if (el) {
                el.scrollIntoView({behavior: 'smooth'});
            }
        },

        handlePage(page) {
            this.$store.dispatch('catalog/handleProductPage', page)
            this.scrollToElement();
        }
    }
})
</script>

<style scoped>

</style>
