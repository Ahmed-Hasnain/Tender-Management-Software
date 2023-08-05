<template>
    <Head title="Quotations" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Quotations</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="url" :searchedKeyword="keyword" :params="params"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <filters 
                            :searchedKeyword="keyword" 
                            :selectedCompany="company" 
                            :selectedStatus="status" 
                            :selectedStartDate="startDate" 
                            :selectedEndDate="endDate" 
                            :selectedLimit="limit" 
                            :totalItems="totalQuotations" 
                            :selectedDepartment="department" 
                            :allDepartments="allDepartments" 
                            :url="url"
                            :reportUrl="reportUrl" 
                            :ids="quotationIds"
                            :reportName="reportName"
                            :type="'quotation'"
                        />
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allQuotations?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 70px;">ID</th>
                                            <th style="width: 225.188px;">Quotaion Reference#</th>
                                            <th style="width: 225.188px;">Tender Reference#</th>
                                            <th style="width: 225.188px;">Total Price</th>
                                            <th style="width: 225.188px;">Status</th>
                                            <th class="text-right" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(quotation, index) in allQuotations.data" :key="index">
                                            <td>{{ quotation.id }}</td>
                                            <td class="text-capitalize">{{ quotation.reference_no }}</td>
                                            <td class="text-capitalize">{{ quotation.tender?.reference_no }}</td>
                                            <td class="text-capitalize">{{ quotation.currency }} {{ formatNumber(quotation.total_price) }}</td>
                                            <td class="text-capitalize">{{ removeDashes(quotation.status) }}</td>
                                            <td class="text-right">
                                                <button @click="quotation.supply_order ? showSupplyOrder(quotation.supply_order.id) : addSupplyOrder(quotation.id) " class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('add_supply_order')">
                                                    <i class="anticon anticon-audit"></i>
                                                </button>
                                                <button @click="show(quotation.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('view_quotation')">
                                                    <i class="anticon anticon-eye"></i>
                                                </button>
                                                <button @click="edit(quotation.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_quotation')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(quotation.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_quotation')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allQuotations" :keyword="keyword" :params="params"></pagination>
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
import filters from '@/Components/Filters.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search,
        filters
    },
    props: ['quotations', 'searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalQuotations', 'quotationIds', 'selectedDepartment', 'allDepartments'],
    data() {
        return{
            allQuotations: this.quotations,
            company: this.selectedCompany,
            status: this.selectedStatus,
            startDate: this.selectedStartDate,
            endDate: this.selectedEndDate,
            limit: this.selectedLimit,
            department: this.selectedDepartment,
            keyword: this.searchedKeyword,
            url: 'dashboard.quotation.index',
            reportUrl: 'dashboard.getQuotationReports',
            reportName: 'Generate Quotation Reports',
            params: {
                company: this.selectedCompany,
                status: this.selectedStatus,
                startDate: this.selectedStartDate,
                endDate: this.selectedEndDate,
                limit: this.selectedLimit,
                department: this.selectedDepartment,
            }
        }
    },
    methods: {
        edit($id){
            this.$inertia.get(route('dashboard.quotation.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        show($id){
            this.$inertia.get(route('dashboard.quotation.show', $id), {
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
                    this.$inertia.delete(route('dashboard.quotation.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
        addSupplyOrder(id) {
            this.$inertia.get(route('dashboard.supply-order.create'), {quotation_id: id}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        showSupplyOrder(id) {
            this.$inertia.get(route('dashboard.supply-order.show', id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        }
    },
    watch: {
        quotations:{
            handler(quotations) {
                this.allQuotations = quotations
            },
            deep: true,
        },
        searchedKeyword:{
            handler(val){
                this.keyword = val;
            },
            deep: true
        }
    },
    mounted() {
        this.emitter.on('get_filters', (args) => {
            if (args.params) {
                this.params.company = args.params.company
                this.params.status = args.params.status
                this.params.startDate = args.params.startDate
                this.params.endDate = args.params.endDate
                this.params.limit = args.params.limit
                this.params.department = args.params.department
            }
        })
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
