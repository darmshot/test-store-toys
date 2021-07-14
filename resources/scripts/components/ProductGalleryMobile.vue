<template>
    <div class="product-gallery-mobile" ref="lightgallery">
        <swiper
            :slidesPerView="'auto'"
            :spaceBetween="5"
        >
            <swiper-slide v-for="(image,key) in gallery" :key="key">
                <a :href="image['full_screen'].src">
                    <img class="img-fluid"
                         :src="image.preview_mobile.src"
                         :width="image.preview_mobile.width"
                         :height="image.preview_mobile.height"
                         :srcset="image.preview_mobile.srcset"
                         loading="lazy"
                         alt="">
                </a>
            </swiper-slide>
        </swiper>
    </div>

</template>

<script>
import {defineComponent} from "vue";

import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/swiper.scss';

import "lightgallery.js"
import "lg-zoom.js"
import "lg-thumbnail.js"
import 'lightgallery.js/src/sass/lightgallery.scss'

export default defineComponent({
    name: "ProductGalleryMobile",
    components: {
        Swiper,
        SwiperSlide
    },

    props: {
        gallery: Object
    },

    mounted() {
        let ref = this.$refs['lightgallery']
        lightGallery(ref, {
            selector: 'a'
        });
    }
})
</script>

<style lang="scss">
/*.product-gallery-mobile*/
.product-gallery-mobile {
    .swiper-slide {
        width: auto;
    }
}


</style>
