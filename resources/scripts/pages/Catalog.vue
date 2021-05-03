<template>
<div>
    this is catalog
    <h3>{{storeName}}</h3>
</div>
</template>
<script>
import catalog from '@/scripts/store/modules/catalog'
import {defineComponent} from "vue";
import {mapState} from "vuex";

export default defineComponent( {
    computed: {
      ...mapState('catalog',[
          'storeName'
      ])
    },
    mounted() {
        console.log('this is catalog')
        this.$store.registerModule('catalog',catalog)
    },
    beforeDestroy() {
        this.$store.unregisterModule('catalog')
    }
})
</script>

<style scoped>

</style>
