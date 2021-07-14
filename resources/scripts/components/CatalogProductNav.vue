<template>
    <div class="catalog-product-nav">
        <el-form :inline="true">
            <el-form-item label="Сортировка:">
                <el-select class="catalog-product-nav__sort" v-model="sortActive" placeholder="Сортировка" @change="handleSort">
                    <el-option
                        v-for="item in sorts"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <template @if="isDesktop">
                <el-form-item>
                    <el-button icon="el-icon-d-arrow-left" :disabled="btnPreviousDisable" @click="handleStartPage"></el-button>
                </el-form-item>
                <el-form-item>
                    <el-button icon="el-icon-arrow-left" :disabled="btnPreviousDisable" @click="handlePrevPage"></el-button>
                </el-form-item>
            </template>

            <el-form-item>
                <el-select class="catalog-product-nav__show" v-model="showActive" placeholder="Показать" @change="handleShow">
                    <el-option
                        v-for="item in shows"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <template @if="isDesktop">
                <el-form-item>
                    <el-button icon="el-icon-arrow-right" :disabled="btnNextDisable" @click="handleNextPage"></el-button>
                </el-form-item>
                <el-form-item>
                    <el-button icon="el-icon-d-arrow-right" :disabled="btnNextDisable" @click="handleEndPage"></el-button>
                </el-form-item>
            </template>
        </el-form>
        <slot></slot>
    </div>
</template>

<script>
import {computed, defineComponent, onMounted, ref} from "vue";
import {useStore} from "vuex";

export default defineComponent({
    name: "CatalogProductNav",
    setup() {
        const store = useStore()

        const shows = computed(() => store.state.catalog.productShows)
        const sorts = computed(() => store.state.catalog.productSorts)

        const showActiveData = computed(() => store.getters["catalog/productShowActiveInfo"])
        const sortActiveData = computed(() => store.getters["catalog/productSortActiveInfo"])

        const productMeta = computed(() => store.state.catalog.productMeta)

        const btnPreviousDisable = computed(() => store.getters["catalog/isStartPage"])
        const btnNextDisable = computed(() => store.getters["catalog/isEndPage"])

        const breakpoint = computed(()=> store.state.common.breakpoint)

        return {
            shows,
            sorts,
            showActiveData,
            sortActiveData,
            productMeta,
            btnPreviousDisable,
            btnNextDisable,
            breakpoint
        }
    },
    data() {
        return {
            showActive: null,
            sortActive: null,
            isDesktop: ['md','lg','xl','xxl'].includes(this.breakpoint)
        }
    },

    mounted() {
        this.showActive = this.showActiveData.value
        this.sortActive = this.sortActiveData.value
    },

    methods: {
        handleShow(value) {
            this.$store.dispatch('catalog/handleProductShow', value)
        },

        handleSort(value) {
            let sortParts = value.split(':');

            this.$store.dispatch('catalog/handleProductSort', {
                sort: sortParts[0],
                order: sortParts[1]
            })
        },

        handlePage(page) {
            this.$store.dispatch('catalog/handleProductPage', page)
            this.scrollToElement();
        },

        scrollToElement() {
            const el = document.getElementById('app');

            if (el) {
                el.scrollIntoView({behavior: 'smooth'});
            }
        },

        handleStartPage() {
            this.handlePage(1)
        },

        handlePrevPage() {
            let currentPage = this.productMeta.current_page
            --currentPage
            this.handlePage(currentPage)
        },

        handleNextPage() {
            let currentPage = this.productMeta.current_page
            ++currentPage
            this.handlePage(currentPage)
        },

        handleEndPage() {
            let lastPage = Math.ceil(this.productMeta.total / this.productMeta.per_page)
            this.handlePage(lastPage)
        },
    }
})
</script>

<style scoped>

</style>
