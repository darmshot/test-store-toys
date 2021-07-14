<template>
    <div class="hamburger">
        <div class="hamburger__block">
            <button @click="handleMenu" class="hamburger__button" type="button">
                <span></span>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import MmenuLight from 'mmenu-light/src/core/index';
import {defineComponent, onMounted, ref} from "vue";

export default defineComponent({
    name:"TheHamburger",
    setup() {
        let domMenu = document.getElementById("my-menu")

            const menu:any = new MmenuLight(
                domMenu
            );

            const navigator = menu.navigation();
            const drawer = menu.offcanvas();


        const mainMenu = ref(null);


        const handleMenu = () => {
               drawer.open();
        }



        return {
            handleMenu,
            mainMenu,
        }
    }
})
</script>

<style scoped>

</style>
