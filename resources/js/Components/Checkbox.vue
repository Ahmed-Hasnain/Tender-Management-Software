<template>
    <div class="checkbox">
        <input type="checkbox" :value="value" v-model="this.checked">
    </div>
</template>

<script>
export default {
    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },
    emits: ['update:checked'],
}
</script>

<style>

</style>
