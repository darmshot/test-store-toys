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
    }
}

// import App from '@/views/App.vue'

import {
    // ElAlert,
    // ElAside,
    // ElAutocomplete,
    // ElAvatar,
    // ElBacktop,
    // ElBadge,
    // ElBreadcrumb,
    // ElBreadcrumbItem,
    ElButton,
    // ElButtonGroup,
    // ElCalendar,
    // ElCard,
    // ElCarousel,
    // ElCarouselItem,
    // ElCascader,
    // ElCascaderPanel,
    // ElCheckbox,
    // ElCheckboxButton,
    // ElCheckboxGroup,
    // ElCol,
    // ElCollapse,
    // ElCollapseItem,
    // ElCollapseTransition,
    // ElColorPicker,
    // ElContainer,
    // ElDatePicker,
    // ElDialog,
    // ElDivider,
    // ElDrawer,
    // ElDropdown,
    // ElDropdownItem,
    // ElDropdownMenu,
    // ElFooter,
    // ElForm,
    // ElFormItem,
    // ElHeader,
    // ElIcon,
    // ElImage,
    // ElInput,
    // ElInputNumber,
    // ElLink,
    // ElMain,
    // ElMenu,
    // ElMenuItem,
    // ElMenuItemGroup,
    // ElOption,
    // ElOptionGroup,
    // ElPageHeader,
    // ElPagination,
    // ElPopconfirm,
    // ElPopover,
    // ElPopper,
    // ElProgress,
    // ElRadio,
    // ElRadioButton,
    // ElRadioGroup,
    // ElRate,
    // ElRow,
    // ElScrollbar,
    // ElSelect,
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


const components = [
    // ElAlert,
    // ElAside,
    // ElAutocomplete,
    // ElAvatar,
    // ElBacktop,
    // ElBadge,
    // ElBreadcrumb,
    // ElBreadcrumbItem,
    ElButton,
    // ElButtonGroup,
    // ElCalendar,
    // ElCard,
    // ElCarousel,
    // ElCarouselItem,
    // ElCascader,
    // ElCascaderPanel,
    // ElCheckbox,
    // ElCheckboxButton,
    // ElCheckboxGroup,
    // ElCol,
    // ElCollapse,
    // ElCollapseItem,
    // ElCollapseTransition,
    // ElColorPicker,
    // ElContainer,
    // ElDatePicker,
    // ElDialog,
    // ElDivider,
    // ElDrawer,
    // ElDropdown,
    // ElDropdownItem,
    // ElDropdownMenu,
    // ElFooter,
    // ElForm,
    // ElFormItem,
    // ElHeader,
    // ElIcon,
    // ElImage,
    // ElInput,
    // ElInputNumber,
    // ElLink,
    // ElMain,
    // ElMenu,
    // ElMenuItem,
    // ElMenuItemGroup,
    // ElOption,
    // ElOptionGroup,
    // ElPageHeader,
    // ElPagination,
    // ElPopconfirm,
    // ElPopover,
    // ElPopper,
    // ElProgress,
    // ElRadio,
    // ElRadioButton,
    // ElRadioGroup,
    // ElRate,
    // ElRow,
    // ElScrollbar,
    // ElSelect,
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


const app = createApp({});

app.component('test', defineAsyncComponent(() => import('@/scripts/components/Test.vue')))
app.component('test-catalog', defineAsyncComponent(() => import('@/scripts/components/TestCatalog.vue')))
app.component('test-home', defineAsyncComponent(() => import('@/scripts/components/TestHome.vue')))

components.forEach(component => {
    app.component(component.name, component)
})


plugins.forEach(plugin => {
    app.use(plugin)
})


if (document.getElementById('catalog-category')) {
    import('@/scripts/store/catalog').then(obj => {
        const store = obj.default
        app.use(store)
        app.mount('#app')
    })
} else {
    import('@/scripts/store').then(obj => {
        const store = obj.default
        app.use(store)
        app.mount('#app')
    })
}

