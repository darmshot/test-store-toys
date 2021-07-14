<template>
    <div class="product-thumb-default">
        <a :href="product.url" class="product-thumb-default__thumb">
            <img v-if="product.thumbs[0]"
                 :src="product.thumbs[0].src"
                 :width="product.thumbs[0].width"
                 :height="product.thumbs[0].height"
                 :srcset="product.thumbs[0].srcset"
                 :sizes="product.thumbs[0].sizes"
                 :alt="product.title"
                 :class="['product-thumb-default__img',{'product-thumb-default__img--hide':(product.thumbs[1])}]"
                 loading="lazy">
            <img v-if="product.thumbs[1]"
                 :src="product.thumbs[1].src"
                 :width="product.thumbs[1].width"
                 :height="product.thumbs[1].height"
                 :srcset="product.thumbs[1].srcset"
                 :sizes="product.thumbs[1].sizes"
                 :alt="product.title"
                 :class="['product-thumb-default__img',{'product-thumb-default__img--hover':(product.thumbs[1])}]"
                 loading="lazy">
        </a>
        <el-rate disabled v-model="rating" class="product-thumb-default__rating"></el-rate>
        <div v-if="product.manufacturer" class="product-thumb-default__sub-title">
            {{ product.manufacturer.title }}
        </div>
        <div class="product-thumb-default__title">
            {{ product.title }}
        </div>
        <div class="product-thumb-default__footer">
            <span class="product-thumb-default__stock-status" v-html="product.stock_status">
            </span>
            <div class="ms-auto">
                <template v-if="product.special">
                    <span class="product-thumb-default__price price price--old" v-html="product.price">
                    </span>
                    <span class="price-percent">{{ product.percent }}</span>
                    <span class="product-thumb-default__price price" v-html="product.special"></span>
                </template>
                <template v-else>
                    <span class="product-thumb-default__price price" v-html="product.price">
                    </span>
                </template>
            </div>
        </div>
    </div>


</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name:"ProductThumbDefault",
    data() {
        return {
            rating:5,
            manufacturer: {
                title: 'Motor & Co R/C'
            },
            price:' 300 BYN'
        }
    },
    props: {
        product: Object
    }
})
</script>

<style lang="scss">

</style>
