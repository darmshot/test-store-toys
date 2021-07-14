<template>
    <div class="product-gallery" ref="container">
        <template v-if="['xs','sm'].includes(breakpoint)">
            <ProductGalleryMobile :gallery="gallery"/>
        </template>
        <template v-else>
            <ProductGalleryDesktop :gallery="gallery"/>
        </template>
    </div>
</template>

<script>


import {computed, defineAsyncComponent, defineComponent} from "vue";
import {useStore} from "vuex";

export default defineComponent({
    name: "ProductGallery",
    components: {
        ProductGalleryMobile: defineAsyncComponent(() => import("@/scripts/components/ProductGalleryMobile.vue")),
        ProductGalleryDesktop: defineAsyncComponent(() => import("@/scripts/components/ProductGalleryDesktop.vue"))
    },
    props: {
        productId: String,
    },
    setup() {
        const store = useStore()

        const breakpoint = computed(() => store.state.common.breakpoint)

        const gallery = computed(()=>store.state.catalog.productGallery)

        return {
            breakpoint,
            gallery
        }
    }
})
</script>

<style scoped>
.product-gallery {
    margin-bottom: 30px;
}
</style>
