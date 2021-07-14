<template>
    <div class="order-history">
        <div class="order-history-item">
            <div class="order-history-item__header">
<!--                <div class="order-history-item__title">-->
<!--                    <a class="text-body" :href="order.view">{{ order.order_title }}</a>-->
<!--                </div>-->
            </div>
            <div class="order-history-item__body">
                <div class="order-history-products">
                    <div>
                        <div v-for="product in cartData" :key="product.product_id" class="order-history-product">
                                            <div  v-if="product.thumb?.src && ['sm','md','lg','xl','xxl'].includes(breakpoint)" class="order-history-product__image">
                                                <img :src="product.thumb.src" loading="lazy" class="img-fluid" alt="">
                                            </div>
                            <div class="order-history-product__title">
                                <span v-html="product.title"></span>
                                                    <div class="order-history-product__title-caption">{{  product.sku }}</div>
                            </div>
                            <div class="order-history-product__model">
                                                    {{  product.sku }}
                            </div>
                            <div class="order-history-product__price">
                                <div class="price" v-html="product.price">
                                </div>
                                <div>
                                    х&nbsp;{{ product.quantity }}
                                </div>
                            </div>
                            <div class="order-history-product__total">
                                <div class="price" v-html="product.total"></div>
                            </div>
                            <div>
                                <el-button class="el-button--size-26-i el-button--transparent-gray-3" @click="handleRemove(product.id)">
                                    <i class="el-icon-close"></i>
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="order-history-item__footer">
              <span class="order-history-item__footer-title">
                {{ cartMeta.quantity }} товар(ов) на сумму:
              </span>
                <div class="order-history-item__total">
                    <div class="price" v-html="cartMeta.total"></div>
                </div>
            </div>
        </div>
    </div>






</template>

<script>
import {useStore} from "vuex";
import {computed, defineComponent} from "vue";

export default defineComponent({
    name: "CheckoutCart",
    setup(){
        const store = useStore()

        const cartData = computed(()=>store.state.common.cartData)
        const cartMeta = computed(()=>store.state.common.cartMeta)

        const breakpoint = computed(()=> store.state.common.breakpoint)


        return {
            cartData,
            cartMeta,
            breakpoint
        }
    },
    data() {
        return {
            // isHideList: true,
        }
    },
    computed: {
        // hideListProducts() {
        //     return (this.isHideList) ? this.products.slice(0, 2) : this.products;
        // },
        // hideButtonText() {
        //     return (this.isHideList) ? 'показать весь список' : 'скрыть список';
        // }
    },

    methods: {
        handleRemove(id) {
            this.$store.dispatch('common/handleRemoveProductFromCart', id);
        }
    }
})
</script>

<style scoped>

</style>
