<script>
import {mapState, useStore} from "vuex";
import {computed, defineComponent} from "vue";

export default defineComponent({
    name:"App",
    setup() {
        const store = useStore()

        const handleSearchBtn = () => {
            store.dispatch('common/handleHeaderDropdown')
        }

        const headerClass = computed(() => {
            return [{'header--dropdown-open': store.state.common.headerDropdown}]

        })

        const breakpoint = computed(()=> store.state.common.breakpoint)

        store.dispatch('common/setup')

        return {
            handleSearchBtn,
            headerClass,
            breakpoint
        }
    },

    created() {
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
    },

    unmounted() {
        window.removeEventListener('resize', this.handleResize);
    },

    methods: {
        handleResize() {
            this.$store.dispatch('common/handleResize', {width: window.innerWidth, height: window.innerHeight})
        },

    }
})
</script>

<style scoped>

</style>
