<template>
    <p>testCatalog component i here</p>
    <h2>{{storeName}}</h2>
</template>

<script lang="ts">
import {mapState} from "vuex";

import {defineComponent} from "vue";

export default defineComponent({
    computed: {
        ...mapState('catalog', [
            'storeName'
        ])
    },
    mounted() {
        console.log('this is catalog')
        // this.$store.registerModule(catalog)
        // console.log(this.$store.catalog.storeName)
    },
    beforeDestroy() {
        // this.$store.unregisterModule('catalog')
    }

})
</script>

<style scoped>

</style>
