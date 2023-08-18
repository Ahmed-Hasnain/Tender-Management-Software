<template>
    <Head title="Delivery Challan" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Delivery Challans</h4>
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
                            :totalItems="totalDeliveryChallans" 
                            :selectedDepartment="department" 
                            :selectedItemStatus="selectedItemStatus" 
                            :selectedAmountIncluded="selectedAmountIncluded"
                            :selectedCurrency="selectedCurrency" 
                            :allDepartments="allDepartments" 
                            :url="url"
                            :reportUrl="reportUrl" 
                            :ids="deliveryChallanIds"
                            :reportName="reportName"
                            :type="'deliveryChallan'"
                            :selectedFilters="selectedFilters"
                        />
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allDeliveryChallan?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 70px;">Ref# </th>
                                            <th style="width: 225.188px;">Quotaion Reference#</th>
                                            <th style="width: 225.188px;">Tender Reference#</th>
                                            <th style="width: 225.188px;">Total Price</th>
                                            <!-- <th style="width: 225.188px;">Tax</th> -->
                                            <th class="text-right" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(deliveryChallan, index) in allDeliveryChallan.data" :key="index">
                                            <td>{{ deliveryChallan.reference_no }}</td>
                                            <td class="text-capitalize">{{ deliveryChallan.supply_order?.quotation?.reference_no }}</td>
                                            <td class="text-capitalize">{{ deliveryChallan.supply_order?.quotation?.tender?.reference_no }}</td>
                                            <td class="text-capitalize">{{ deliveryChallan.supply_order?.quotation?.currency }} {{ formatNumber(deliveryChallan.total) }}</td>
                                            <!-- <td class="text-capitalize">{{ deliveryChallan.supply_order?.quotation?.currency }} {{formatNumber(calculateTax(deliveryChallan.total, deliveryChallan.supply_order?.quotation?.tax))}}</td> -->
                                            <td class="text-right">
                                                <button @click="show(deliveryChallan.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('view_delivery_challan')">
                                                    <i class="anticon anticon-eye"></i>
                                                </button>
                                                <button @click="onDelete(deliveryChallan.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_delivery_challan')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="deliveryChallan" :keyword="keyword" :params="params"></pagination>
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
    props: ['deliveryChallan', 'searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalDeliveryChallans', 'deliveryChallanIds', 'selectedDepartment', 'allDepartments', 'selectedItemStatus', 'selectedAmountIncluded', 'selectedCurrency'],
    data() {
        return{
            allDeliveryChallan: this.deliveryChallan,
            company: this.selectedCompany,
            status: this.selectedStatus,
            startDate: this.selectedStartDate,
            endDate: this.selectedEndDate,
            limit: this.selectedLimit,
            department: this.selectedDepartment,
            item_status: this.selectedItemStatus,
            amount_included: this.selectedAmountIncluded,
            currency: this.selectedCurrency,
            keyword: this.searchedKeyword,
            url: 'dashboard.delivery-challan.index',
            reportUrl: 'dashboard.getDeliveryChallanReports',
            reportName: 'Generate Delivery Challan Reports',
            params: {
                company: this.selectedCompany,
                status: this.selectedStatus,
                startDate: this.selectedStartDate,
                endDate: this.selectedEndDate,
                limit: this.selectedLimit,
                department: this.selectedDepartment,
                item_status: this.selectedItemStatus,
                amount_included: this.selectedAmountIncluded,
                currency: this.selectedCurrency,
            },
            selectedFilters: [
                'company',
                'status',
                'start_date',
                'end_date',
                'limit',
                'department',
                'currency'
            ],
        }
    },
    methods: {
        edit($id){
            this.$inertia.get(route('dashboard.delivery-challan.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        show($id){
            this.$inertia.get(route('dashboard.delivery-challan.show', $id), {
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
                    this.$inertia.delete(route('dashboard.delivery-challan.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        }
    },
    watch: {
        deliveryChallan:{
            handler(deliveryChallan) {
                this.allDeliveryChallan = deliveryChallan
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
                this.params.item_status = args.params.item_status
                this.params.amount_included = args.params.amount_included
                this.params.currency = args.params.currency
            }
        })
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
