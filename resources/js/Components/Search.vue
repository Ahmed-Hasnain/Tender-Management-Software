<template>
    <input type="search" class="form-control form-control-sm" placeholder="Type here..." v-model="keyword"
        @keyup="search">
</template>

<script>
export default {
    props: ['url', 'params', 'searchedKeyword'],
    data() {
        return {
            keyword: this.searchedKeyword,
        }
    },
    methods: {
        search() {
            this.$inertia.replace(route(this.url, {
                    keyword: this.keyword,
                    params: this.params,
                })
            );
        }
    },  
}
</script>

<style>

</style>