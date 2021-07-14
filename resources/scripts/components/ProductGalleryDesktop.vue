<template>
    <div ref="lightgallery" class="product-gallery-desktop">
        <a v-for="(image,key) in gallery" :key="key" :href="image.full_screen.src" class="product-gallery-desktop__item">
            <img class="img-fluid" :src="image.preview_desktop.src"
                 :width="image.preview_desktop.width"
                 :height="image.preview_desktop.height"
                 :srcset="image.preview_desktop.srcset"
                 :sizes="image.preview_desktop.sizes"
                 loading="lazy"
                 alt="">
        </a>
    </div>
</template>

<script>

import "lightgallery.js"
import "lg-zoom.js"
import "lg-thumbnail.js"
import 'lightgallery.js/src/sass/lightgallery.scss'


import {defineComponent} from "vue";

export default defineComponent({
    name: "ProductGalleryDesktop",

    props: {
        gallery: Object
    },

    mounted() {
        let ref = this.$refs['lightgallery']
        lightGallery(ref);
    }
})
</script>

<style lang="scss" scoped>
.product-gallery-desktop {
    column-count: 2;
    column-gap: 0;
    margin-right: -2px;
    margin-left: -2px;

    &__item {
        display: inline-block;
        padding: 2px;
        break-inside: avoid;
    }
}
</style>
