<template>
    <div class="alert" :class="`alert-${style}`" v-if="message">
        {{ message }}
    </div>
</template>

<script>
export default {
    computed: {
        style() {
            return this.$page.props.flash?.bannerStyle || ''
        },

        message() {
            return this.$page.props.flash?.banner || ''
        },
    }

}
</script>

<style>

</style>