<template>
    <Head title="Tenders" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Tenders</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <button class="btn btn-primary btn-sm" @click="add()" v-if="checkUserPermissions('add_tender')">
                                    <i class="anticon anticon-file-protect"></i>
                                    <span>Add Tender</span>
                                </button>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.tender.index'" :searchedKeyword="searchedKeyword"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allTenders?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 225.188px;">Reference #</th>
                                            <th style="width: 225.188px;">Client</th>
                                            <!-- <th style="width: 225.188px;">RFQ Date</th> -->
                                            <th style="width: 225.188px;">LDoS</th>
                                            <th style="width: 225.188px;">Company</th>
                                            <th style="width: 225.188px;">Status</th>
                                            <th class="text-right" style="width: 255.188px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(tender,index) in allTenders.data" :key="index">
                                            <td class="text-capitalize">{{ tender.reference_no }}</td>
                                            <td class="text-capitalize">{{ tender.client?.name }}</td>
                                            <!-- <td class="text-capitalize">{{ formatDate(tender.rfq_date) }}</td> -->
                                            <td class="text-capitalize">{{ formatDate(tender.last_date_of_submission) }}</td>
                                            <td class="text-capitalize">{{ tender.company?.name }}</td>
                                            <td class="text-capitalize">{{ removeDashes(tender.status) }}</td>
                                            <td class="text-right">
                                                <button @click="tender.quotation ? showTender(tender.quotation.id) : addTender(tender.id) " class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('add_quotation')">
                                                    <i class="anticon anticon-file-text"></i>
                                                </button>
                                                <button @click="show(tender.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('view_tender')">
                                                    <i class="anticon anticon-eye"></i>
                                                </button>
                                                <button @click="edit(tender.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_tender')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(tender.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_tender')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allTenders" :keyword="searchedKeyword"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Helpers from '@/Mixins/Helpers';
import pagination from '@/Components/Pagination.vue';
import search from '@/Components/Search.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search
    },
    props: ['tenders', 'searchedKeyword'],
    data() {
        return{
            allTenders: this.tenders
        }
    },
    methods: {
        add(){
            this.$inertia.get(route('dashboard.tender.create'), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        edit($id){
            this.$inertia.get(route('dashboard.tender.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        show($id){
            this.$inertia.get(route('dashboard.tender.show', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        onDelete($id) {
            this.swal.fire({
                title: "",
                html: "<h1 class='text-lg text-gray-800 mb-1'>Delete Record</h1><p class='text-base'>Are you sure want to delete this record?</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Delete Record",
                customClass: {
                confirmButton: 'danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('dashboard.tender.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
        addTender(id) {
            this.$inertia.get(route('dashboard.quotation.create'), {tender_id: id}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        showTender(id) {
            this.$inertia.get(route('dashboard.quotation.show', id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        }
    },
    watch: {
        tenders:{
            handler(tenders) {
                this.allTenders = tenders
            },
            deep: true,
        },
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
