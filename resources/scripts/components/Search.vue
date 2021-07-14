<template>
    <div class="search">
        <!--        @keyup.enter.native="handleSearch"-->
        <!--        ref="search"-->
        <!--        :popper-append-to-body="false"-->

        <!--        prefix-icon="el-icon-search"-->
        <!--        class="input-with-select"-->
        <!--        popper-class="search__autocomplete"-->
        <!--        :popper-append-to-body="false"-->

        <!--        <el-autocomplete-->
        <!--            placeholder="Поиск"-->


        <!--            v-model="state"-->
        <!--            :fetch-suggestions="querySearch"-->
        <!--            :trigger-on-focus="false"-->
        <!--            @select="handleSelect"-->

        <!--        >-->
        <!--            <template #default="{ item }">-->
        <!--                <ProductThumbAutocomplete :product="item"/>-->
        <!--            </template>-->
        <!--            <el-button @click="handleSearch" slot="append" icon="el-icon-search"></el-button>-->
        <!--        </el-autocomplete>-->


        <el-autocomplete
            prefix-icon="el-icon-search"
            class="inline-input input-with-select"
            popper-class="search__autocomplete "
            v-model="state"
            :fetch-suggestions="querySearch"
            placeholder="Поиск"
            :trigger-on-focus="false"
            @select="handleSelect"

        >
            <template #default="{ item }">
                <ProductThumbAutocomplete :product="item"/>
            </template>

        </el-autocomplete>
    </div>


</template>

<script>
import {computed, defineComponent, onMounted, ref} from "vue";
import {useStore} from "vuex";
import ProductThumbAutocomplete from "@/scripts/components/ProductThumbAutocomplete.vue";

export default defineComponent({
    name: "Search",
    components: {
        ProductThumbAutocomplete
    },
    setup() {
        const restaurants = ref([]);

        const store = useStore();

        const querySearch = (queryString, cb) => {
            store.dispatch('common/loadSearchAutocomplete', queryString).then((result) => {
                cb(result);
            })
        };
        const handleSelect = (item) => {
            // console.log(item);
        };
        return {
            restaurants,
            state: ref(''),
            querySearch,
            // createFilter,
            // loadAll,
            handleSelect,
        };
    },


})
</script>

<style lang="scss">

.search {
    &__autocomplete {
        //display: none;
        .el-autocomplete-suggestion__list li:not(:last-child) {
            margin-bottom: 10px !important;
        }

        //background: $gray-900;
        //border-color: $gray-900;
        //color: white;
    }

    .el-autocomplete {
        width: 100%;
    }

    .el-input__inner {
        padding-left: 35px;
        height: 54px;
        line-height: 54px;
        border-radius: 30px;
        font-size: 16px;
    }

    .el-input-group__append, .el-input-group__prepend {
        background: $primary !important;
        border-color: $primary !important;
    }

    .el-button {
        background: $primary !important;
        border-color: $primary !important;
        font-size: 20px;
        padding: 14px 17px;
        transition: .3s;

        i {
            color: white !important;
        }

        &:hover {
            background: darken($primary, 5%) !important;
            border-color: darken($primary, 5%) !important;
        }
    }
    .el-input__prefix {
        left: 15px;
    }
    .el-input--prefix .el-input__inner {
        padding-left: 45px;
    }
    .el-input__icon {
        color: $primary;
        font-size: 25px;
        line-height: 54px;
    }
}
</style>
