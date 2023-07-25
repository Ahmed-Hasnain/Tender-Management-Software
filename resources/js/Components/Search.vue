<template>
    <input type="search" class="form-control form-control-sm" placeholder="Search here..." v-model="keyword"
        @keyup="search">
</template>

<script>
export default {
    props: ['url', 'params', 'searchedKeyword', 'id'],
    data() {
        return {
            keyword: this.searchedKeyword,
            allParams: this.params,
        }
    },
    methods: {
        search() {
            this.$inertia.replace(route(this.url, {
                    company_id: this.id ? this.id : null,
                    keyword: this.keyword,
                    params: this.allParams,
                })
            );
        }
    },  
}
</script>

<style>

</style>