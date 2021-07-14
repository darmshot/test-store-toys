/*
|--------------------------------------------------------------------------
| Main entry point
|--------------------------------------------------------------------------
| Files in the "resources/scripts" directory are considered entrypoints
| by default.
|
| -> https://vitejs.dev
| -> https://github.com/innocenzi/laravel-vite
*/


import "vite/dynamic-import-polyfill"
import "@/sass/vendor.scss"
import 'element-plus/packages/theme-chalk/src/base.scss'
import '@/sass/app.scss'

import {createApp, defineAsyncComponent, defineComponent} from 'vue'

declare global {
    interface Window {
        createApp: any;
        // axios: any;
    }
}


import {
    // ElAlert,
    // ElAside,
    ElAutocomplete,
    // ElAvatar,
    // ElBacktop,
    // ElBadge,
    ElBreadcrumb,
    ElBreadcrumbItem,
    ElButton,
    // ElButtonGroup,
    // ElCalendar,
    // ElCard,
    ElCarousel,
    ElCarouselItem,
    // ElCascader,
    // ElCascaderPanel,
    // ElCheckbox,
    // ElCheckboxButton,
    // ElCheckboxGroup,
    // ElCol,
    ElCollapse,
    ElCollapseItem,
    ElCollapseTransition,
    // ElColorPicker,
    // ElContainer,
    // ElDatePicker,
    // ElDialog,
    // ElDivider,
    // ElDrawer,
    ElDropdown,
    ElDropdownItem,
    ElDropdownMenu,
    // ElFooter,
    ElForm,
    ElFormItem,
    // ElHeader,
    // ElIcon,
    // ElImage,
    ElInput,
    // ElInputNumber,
    // ElLink,
    // ElMain,
    // ElMenu,
    // ElMenuItem,
    // ElMenuItemGroup,
    ElOption,
    // ElOptionGroup,
    // ElPageHeader,
    ElPagination,
    // ElPopconfirm,
    // ElPopover,
    // ElPopper,
    // ElProgress,
    ElRadio,
    // ElRadioButton,
    ElRadioGroup,
    ElRate,
    // ElRow,
    // ElScrollbar,
    ElSelect,
    // ElSlider,
    // ElStep,
    // ElSteps,
    // ElSubmenu,
    // ElSwitch,
    // ElTabPane,
    // ElTable,
    // ElTableColumn,
    // ElTabs,
    // ElTag,
    // ElTimePicker,
    // ElTimeSelect,
    // ElTimeline,
    // ElTimelineItem,
    // ElTooltip,
    // ElTransfer,
    // ElTree,
    // ElUpload,
    // ElInfiniteScroll,
    ElLoading,
    ElMessage,
    ElMessageBox,
    ElNotification,
} from 'element-plus';

import Search from '@/scripts/components/Search.vue';
// import axiosInstance from "@/scripts/modules/axios-instance";
import App from "@/scripts/components/App.vue";

const components = [
    // ElAlert,
    // ElAside,
    ElAutocomplete,
    // ElAvatar,
    // ElBacktop,
    // ElBadge,
    ElBreadcrumb,
    ElBreadcrumbItem,
    ElButton,
    // ElButtonGroup,
    // ElCalendar,
    // ElCard,
    ElCarousel,
    ElCarouselItem,
    // ElCascader,
    // ElCascaderPanel,
    // ElCheckbox,
    // ElCheckboxButton,
    // ElCheckboxGroup,
    // ElCol,
    ElCollapse,
    ElCollapseItem,
    ElCollapseTransition,
    // ElColorPicker,
    // ElContainer,
    // ElDatePicker,
    // ElDialog,
    // ElDivider,
    // ElDrawer,
    ElDropdown,
    ElDropdownItem,
    ElDropdownMenu,
    // ElFooter,
    ElForm,
    ElFormItem,
    // ElHeader,
    // ElIcon,
    // ElImage,
    ElInput,
    // ElInputNumber,
    // ElLink,
    // ElMain,
    // ElMenu,
    // ElMenuItem,
    // ElMenuItemGroup,
    ElOption,
    // ElOptionGroup,
    // ElPageHeader,
    ElPagination,
    // ElPopconfirm,
    // ElPopover,
    // ElPopper,
    // ElProgress,
    ElRadio,
    // ElRadioButton,
    ElRadioGroup,
    ElRate,
    // ElRow,
    // ElScrollbar,
    ElSelect,
    // ElSlider,
    // ElStep,
    // ElSteps,
    // ElSubmenu,
    // ElSwitch,
    // ElTabPane,
    // ElTable,
    // ElTableColumn,
    // ElTabs,
    // ElTag,
    // ElTimePicker,
    // ElTimeSelect,
    // ElTimeline,
    // ElTimelineItem,
    // ElTooltip,
    // ElTransfer,
    // ElTree,
    // ElUpload,
]

const plugins = [
    // ElInfiniteScroll,
    ElLoading,
    ElMessage,
    ElMessageBox,
    ElNotification,
]


const app = createApp(App);
// window.Vue = app;
// app.config.globalProperties.$axiosInstance = axiosInstance

app.component('test', defineAsyncComponent(() => import('@/scripts/components/Test.vue')))
app.component('test-catalog', defineAsyncComponent(() => import('@/scripts/components/TestCatalog.vue')))
app.component('test-home', defineAsyncComponent(() => import('@/scripts/components/TestHome.vue')))
app.component('products', defineAsyncComponent(() => import('@/scripts/components/Products.vue')))
app.component('main-slider', defineAsyncComponent(() => import('@/scripts/components/MainSlider.vue')))
app.component('cart-dropdown', defineAsyncComponent(() => import('@/scripts/components/CartDropdown.vue')))
app.component('the-hamburger', defineAsyncComponent(() => import('@/scripts/components/TheHamburger.vue')))
app.component('catalog-product', defineAsyncComponent(() => import('@/scripts/components/CatalogProduct.vue')))
app.component('product-gallery', defineAsyncComponent(() => import('@/scripts/components/ProductGallery.vue')))
app.component('checkout', defineAsyncComponent(() => import('@/scripts/components/Checkout.vue')))

app.component('search', Search)

components.forEach(component => {
    app.component(component.name, component)
})


plugins.forEach(plugin => {
    app.use(plugin)
})


let pageIdData = document.querySelectorAll('div.content-body')
let pageId = pageIdData[0].id;

if (pageId.match(/^catalog-/i)) {

    import('@/scripts/store/catalog').then(obj => {
        const store = obj.default

        store.dispatch('pageRoute/setup')

        if (pageId == 'catalog-category') {
            // @ts-ignore
            store.dispatch('catalog/setup', {productRoute: `/api/catalog/categories/${vars?.category?.id}/products`})
        }else if(pageId == 'catalog-product') {
            // @ts-ignore
            store.dispatch('catalog/setup', {productGallery: vars?.product?.gallery})
        }


        app.use(store)

        app.mount('#app')



    })
}else if(pageId.match(/^checkout-/i)){
    import('@/scripts/store/checkout').then(obj => {
        const store = obj.default
        store.dispatch('pageRoute/setup')

        app.use(store)
        app.mount('#app')
    })
} else {
    import('@/scripts/store').then(obj => {
        const store = obj.default

        store.dispatch('pageRoute/setup')

        if (pageId == 'page-search') {
            // @ts-ignore
            store.dispatch('catalog/setup', {productRoute: `/api/search`})
        }

        app.use(store)


        app.mount('#app')
    })
}


