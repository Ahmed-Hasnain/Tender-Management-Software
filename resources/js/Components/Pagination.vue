<template>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{meta.from}} to {{ meta.to }} of {{ meta.total }} entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                <ul class="pagination">
                    <div v-for="(link, index) in meta.links" :key="index">
                        <li class="paginate_button page-item " :class="{ 'active': link.active }">
                            <Link v-if="link.url !== null" class="page-link" :href="pageUrl(link.url)"
                                v-html="link.label">
                            </Link>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link,
    },
    props: ['meta', 'keyword', 'company_id', 'params'],
    data(){
        return {
            allParams : this.params,
        }
    },
    methods: {
        pageUrl(url) {
            let searchedKeyword = this.keyword ? '&keyword=' + this.keyword : ''
            searchedKeyword = this.company_id ? searchedKeyword + '&company_id=' + this.company_id : searchedKeyword
            let status = this.allParams ? '&params[status]=' + this.allParams.status : ''
            let company = this.allParams ? '&params[company]=' + this.allParams.company : ''
            let department = this.allParams ? '&params[department]=' + this.allParams.department : ''
            let startDate = this.allParams ? '&params[startDate]=' + this.allParams.startDate : ''
            let endDate = this.allParams ? '&params[endDate]=' + this.allParams.endDate : ''
            let limit = this.allParams ? '&params[limit]=' + this.allParams.limit : ''
            return url + searchedKeyword + company + status + department + startDate + endDate + limit  
        }
    },
}
</script>

<style>

</style>