<template>
    <Head title="Welcome" />
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <my-header></my-header>
            <!-- Header END -->
            <!-- Side Nav START -->
            <my-sidebar></my-sidebar>
            <!-- Side Nav END -->
            <!-- Page Container START -->
            <div class="page-container">
                <!-- Content Wrapper START -->
                <div class="main-content">
                    <my-banner></my-banner>
                    <slot />
                </div>
                <!-- Content Wrapper END -->
                <!-- Footer START -->
                <my-footer></my-footer>
                <!-- Footer END -->
            </div>
            <!-- Page Container END -->
        </div>
    </div>
</template>

<script>
    import myFooter from '../Components/Footer.vue'
    import myHeader from '../Components/Header.vue'
    import mySidebar from '../Components/Sidebar.vue'
    import myBanner from '../Components/banner.vue'
    import Helpers from '../Mixins/Helpers'
export default {
    components: {
        myFooter,
        myHeader,
        mySidebar,
        myBanner
    },
    mixins: [Helpers]
}
</script>

<style>
    .main-content {
        background-color: #e6e7e8 !important;
    }

    select,input,textarea{
        border : 2px solid #e6e7e8 !important;
    }
</style>