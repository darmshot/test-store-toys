<template>
    <p>testHome component i here</p>
    <h2>{{storeName}}</h2>
</template>

<script  lang="ts">
import {mapState} from "vuex";

export default {
    name:"TestHome",
    computed:{
        ...mapState('common',[
            'storeName'
        ])

    }
}
</script>

<style scoped>

</style>
