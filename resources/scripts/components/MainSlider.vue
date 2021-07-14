<template>
    <el-carousel class="main-slider" :height="height" :interval="6000">
        <div v-for="(item,key) in sliders" :key="key">
            <el-carousel-item v-if="item.image">
                <div class="main-slider-content" :class="item.class">
                    <div class="main-slider-content__image-wrapper">
                        <template v-if="item.image_mobile">
                            <picture>
                                <source class="main-slider-content__image" :srcset="item.image" media="(min-width: 768px)">
                                <img class="main-slider-content__image"
                                     :src="item.image_mobile"
                                     :alt="item.title"
                                     loading="lazy">
                            </picture>
                        </template>
                        <template v-else>
                            <img class="main-slider-content__image"
                                 :src="item.image"
                                 :alt="item.title"
                                 loading="lazy">
                        </template>
                    </div>
                    <div class="main-slider-content__container container">
                        <div class="main-slider-content__text-wrapper">
                            <div v-html="item.description"></div>
                            <!--                            <div class="display-2 text-white mb-8">-->
                            <!--                              Стильно модно молодежно-->
                            <!--                            </div>-->
                            <!--                            <a href="/podbor_po_proizvoditely" class="el-button el-button&#45;&#45;size-48 el-button&#45;&#45;transparent-white-1-uppercase">Посмотреть</a>-->
                        </div>
                    </div>
                </div>
            </el-carousel-item>
        </div>
    </el-carousel>
</template>

<script>
import {computed, defineComponent} from "vue";
import {useStore} from "vuex";

export default defineComponent({
    name: "MainSlider",
    setup() {
        const store = useStore()

        const breakpoint = computed(() => store.state.common.breakpoint)

        return {
            breakpoint
        }
    },

    props: {
        sliders: Array
    },

    computed: {
        height() {
            return (['xs', 'sm', 'md'].includes(this.breakpoint)) ? '320px' : '560px'
        },
    }
})
</script>

<style>

</style>
