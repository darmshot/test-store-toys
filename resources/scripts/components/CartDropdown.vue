<template>
    <div class="cart-dropdown">
        <el-dropdown v-cloak trigger="click">
            <div class="cart-dropdown__dropdown-link el-dropdown-link">
                <div class="cart-dropdown__icon-wrapper">
                    <div class="cart-dropdown__quantity">{{ cart.quantity }}</div>
                    <svg width="30" height="30" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.665899 2.16342H2.5748L5.2939 11.9965C5.37157 12.2851 5.63793 12.4849 5.93759 12.4849H14.2946C14.561 12.4849 14.794 12.3295 14.905 12.0853L17.9459 5.09337C18.0347 4.88252 18.0125 4.64945 17.8904 4.46077C17.7683 4.27209 17.5575 4.16112 17.3355 4.16112H8.10176C7.73552 4.16112 7.43586 4.46077 7.43586 4.82701C7.43586 5.19326 7.73552 5.49291 8.10176 5.49291H16.3145L13.8507 11.1531H6.43701L3.71795 1.31996C3.64028 1.03139 3.37392 0.831619 3.07426 0.831619H0.665899C0.299655 0.831619 0 1.13127 0 1.49752C0 1.86376 0.299655 2.16342 0.665899 2.16342Z" fill="white"/>
                        <path d="M5.30501 17.1684C6.13739 17.1684 6.81437 16.4914 6.81437 15.659C6.81437 14.8266 6.13739 14.1496 5.30501 14.1496C4.47264 14.1496 3.79565 14.8266 3.79565 15.659C3.79565 16.4913 4.47264 17.1684 5.30501 17.1684Z" fill="white"/>
                        <path d="M14.7385 17.1684C14.7718 17.1684 14.8162 17.1684 14.8495 17.1684C15.249 17.1351 15.6153 16.9575 15.8816 16.6467C16.148 16.3471 16.2701 15.9586 16.2479 15.548C16.1924 14.7267 15.471 14.0941 14.6387 14.1496C13.8063 14.2051 13.1848 14.9376 13.2403 15.7588C13.2957 16.5468 13.9505 17.1684 14.7385 17.1684Z" fill="white"/>
                    </svg>
                </div>
                <div v-show="['sm','md','lg','xl','xxl'].includes(breakpoint)" class="cart-dropdown__price">
                    <span v-html="cart.total"></span>
                </div>
            </div>

            <template #dropdown>
                <el-dropdown-menu class="cart-dropdown__dropdown">
                    <template v-if="items.length !== 0">
                        <div class="cart-dropdown__products">
                            <div class="cart-dropdown__item cart-dropdown__product"
                                 v-for="(item) in items"
                                 :key="item.id">
                                <div class="cart-dropdown__product-title">
                                    <a  :href="item.url">{{ item.title }}</a>
                                </div>
                                <div class="cart-dropdown__product-quantity">
                                    x{{ item.quantity }}
                                </div>
                                <div class="cart-dropdown__product-price" v-html="item.price ">

                                </div>
                                <div class="cart-dropdown__product-delete">
                                    <el-button class="el-button--size-26-i el-button--transparent-gray-3" @click="handleRemove(item.id)">
                                        <i class="el-icon-close"></i>
                                    </el-button>
                                </div>
                            </div>
                        </div>
                        <div class="cart-dropdown__product-totals">
                            <div class="cart-dropdown__item cart-dropdown__product-total">
                                <div class="cart-dropdown__product-total-title">
                                    Сумма
                                </div>
                                <div class="cart-dropdown__product-total-price" v-html="cart.total">

                                </div>
                            </div>
                        </div>
                        <div class="cart-dropdown__footer">
<!--                            <a :href="cart.cart" class="el-button el-button&#45;&#45;size-32 el-button&#45;&#45;transparent-white-1-uppercase">Посмотреть-->
<!--                                корзину-->
<!--                            </a>-->
                            <a :href="cart.checkout" class="el-button el-button--size-32 el-button--orange-1-up">Оформить
                                заказ
                            </a>
                        </div>
                    </template>
                    <template v-else>
                        <div class="cart-dropdown__empty">
                            Ваша корзина пуста!
                        </div>

                    </template>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>

</template>

<script>
import {mapState, useStore} from "vuex";
import {computed, defineComponent} from "vue";

export default defineComponent({
    name: "CartDropdown",
    setup() {
        const store = useStore()

        const items = computed(() => store.state.common.cartData)
        const cart = computed(() => store.state.common.cartMeta)

        const  breakpoint = computed(()=>store.state.common.breakpoint)
        return {
            items,
            cart,
            breakpoint
        }
    },

    methods: {
        handleRemove(id) {
            this.$store.dispatch('common/handleRemoveProductFromCart', id);
        }
    }

})
</script>

<style scoped lang="scss">


</style>
