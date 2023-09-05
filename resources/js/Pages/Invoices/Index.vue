<template>
    <Head title="Supply Orders" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Supply Orders</h4>
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
                            :totalItems="totalSupplyOrders" 
                            :selectedDepartment="department" 
                            :allDepartments="allDepartments" 
                            :selectedCurrency="selectedCurrency" 
                            :selectedStiStatus="sti_status"
                            :selectedCiStatus="ci_status"
                            :selectedPrStatus="pr_status"
                            :url="url"
                            :reportUrl="reportUrl" 
                            :ids="supplyOrderIds"
                            :reportName="reportName"
                            :type="'invoices'"
                            :selectedFilters="selectedFilters"
                        />
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allSupplyOrder?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 225.188px;">Quotaion Ref#</th>
                                            <th style="width: 225.188px;">Tender Ref#</th>
                                            <th style="width: 225.188px;">File Name</th>
                                            <th style="width: 225.188px;">Price without GST</th>
                                            <th style="width: 225.188px;">Price with  GST</th>
                                            <th style="width: 225.188px;">Status</th>
                                            <th class="text-right" style="width: 300px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(supplyOrder, index) in allSupplyOrder.data" :key="index">
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.tender?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.tender?.file_name }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.currency }} {{ formatNumber(supplyOrder.total_price) }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.currency }} {{ getTotal(supplyOrder.total_price, calculateTax(supplyOrder.total_price, supplyOrder.quotation?.tax)) }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.status }}</td>
                                            <td class="text-right">
                                                <a v-if="company" :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'sale_tax_invoice'])" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right mx-1" :class="[supplyOrder.sti_downloaded == 1 ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-dollar"></i>
                                                </a>
                                                <a v-if="company" :href="route('dashboard.downloadSupplyOrder', [supplyOrder.id, company, 'commercial_invoice'])" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" :class="[supplyOrder.ci_downloaded == 1 ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-copyright"></i>
                                                </a>
                                                <button @click="supplyOrder.payment_recieving ? showPaymentRecieving(supplyOrder.payment_recieving.id) : addPaymentRecieving(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right mx-1" v-if="checkUserPermissions('add_payment_recieving')" :class="[supplyOrder.payment_recieving ? 'bg-success text-white' : '']">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allSupplyOrder" :keyword="keyword" :params="params"></pagination>
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
    name:'Invoices',
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search,
        filters
    },
    props: ['supplyOrder', 'searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalSupplyOrders', 'supplyOrderIds', 'selectedDepartment', 'allDepartments', 'selectedCurrency', 'selectedStiStatus', 'selectedCiStatus', 'selectedPrStatus'],
    data() {
        return{
            allSupplyOrder: this.supplyOrder,
            company: this.selectedCompany,
            status: this.selectedStatus,
            startDate: this.selectedStartDate,
            endDate: this.selectedEndDate,
            limit: this.selectedLimit,
            department: this.selectedDepartment,
            currency: this.selectedCurrency,
            sti_status: this.selectedStiStatus,
            ci_status: this.selectedCiStatus,
            pr_status: this.selectedPrStatus,
            keyword: this.searchedKeyword,
            url: 'dashboard.invoices',
            reportUrl: 'dashboard.getInvoiceReports',
            reportName: 'Generate Invoice Reports',
            params: {
                company: this.selectedCompany,
                status: this.selectedStatus,
                startDate: this.selectedStartDate,
                endDate: this.selectedEndDate,
                limit: this.selectedLimit,
                department: this.selectedDepartment,
                currency: this.selectedCurrency,
                sti_status: this.selectedStiStatus,
                ci_status: this.selectedCiStatus,
                pr_status: this.selectedPrStatus,
            },
            selectedFilters: [
                'company',
                'status',
                'start_date',
                'end_date',
                'limit',
                'department',
                'currency',
                'sti_status',
                'ci_status',
                'pr_status',
            ],
        }
    },
    methods: {
        getInvoices(){
            this.$inertia.get(route('dashboard.invoices'), {company: this.company}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },

        showPaymentRecieving(id){
            this.$inertia.get(route('dashboard.payment-recieving.show', id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },

        addPaymentRecieving(supplyOrderId){
            this.$inertia.get(route('dashboard.payment-recieving.create'), {supplyOrder: supplyOrderId}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
    },
    watch: {
        supplyOrder:{
            handler(supplyOrder) {
                this.allSupplyOrder = supplyOrder
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
    mounted(){
        this.emitter.on('get_filters', (args) => {
            if (args.params) {
                this.params.company = args.params.company
                this.params.status = args.params.status
                this.params.startDate = args.params.startDate
                this.params.endDate = args.params.endDate
                this.params.limit = args.params.limit
                this.params.department = args.params.department
                this.params.currency = args.params.currency
                this.params.sti_status = args.params.sti_status
                this.params.ci_status = args.params.ci_status
                this.params.pr_status = args.params.pr_status
            }
        })
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
