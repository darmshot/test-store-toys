<template>
    <div class="checkout container">
        <template v-if="cartData.length !== 0">
        <div class="row">
            <div class="col-sm-7">
                <CheckoutCart/>
            </div>
            <div class="col-sm-5">
                <CheckoutForm/>
            </div>
        </div>
        </template>
        <template v-else>
            <p>Ваша корзина пуста!</p>
        </template>
    </div>
</template>

<script>
import {computed, defineComponent} from "vue";
import CheckoutCart from "@/scripts/components/CheckoutCart.vue";
import CheckoutForm from "@/scripts/components/CheckoutForm.vue";
import {useStore} from "vuex";

export default defineComponent({
    name: "Checkout",
    components: {
        CheckoutCart,
        CheckoutForm
    },
    setup() {
        const store = useStore()

        const cartData = computed(() => store.state.common.cartData)
        const cartMeta = computed(() => store.state.common.cartMeta)

        const breakpoint = computed(() => store.state.common.breakpoint)


        return {
            cartData,
            cartMeta,
            breakpoint
        }
    },
})
</script>

<style scoped>
.checkout {
}
</style>
