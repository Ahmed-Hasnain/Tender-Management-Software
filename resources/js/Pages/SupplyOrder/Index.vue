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
                            :selectedItemStatus="selectedItemStatus" 
                            :selectedAmountIncluded="selectedAmountIncluded" 
                            :url="url"
                            :reportUrl="reportUrl" 
                            :ids="supplyOrderIds"
                            :reportName="reportName"
                            :type="'supplyOrder'"
                            :selectedFilters="selectedFilters"
                        />
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allSupplyOrder?.data.length > 0">
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
                                        <tr role="row" class="odd" v-for="(supplyOrder, index) in allSupplyOrder.data" :key="index">
                                            <td>{{ supplyOrder.id }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.tender?.reference_no }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.quotation?.currency }} {{ formatNumber(supplyOrder.total_price) }}</td>
                                            <td class="text-capitalize">{{ supplyOrder.status }}</td>
                                            <td class="text-right">
                                                <button @click="supplyOrder.delivered == 1 ? showDeliveryChallan(supplyOrder.id) : addDeliveryChallan(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('add_delivery_challan')">
                                                    <i class="anticon anticon-reconciliation"></i>
                                                </button>
                                                <button @click="show(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('view_supply_order')">
                                                    <i class="anticon anticon-eye"></i>
                                                </button>
                                                <button @click="edit(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_supply_order')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(supplyOrder.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_supply_order')">
                                                    <i class="anticon anticon-delete"></i>
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
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search,
        filters
    },
    props: ['supplyOrder', 'searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalSupplyOrders', 'supplyOrderIds', 'selectedDepartment', 'allDepartments', 'selectedCurrency', 'selectedItemStatus', 'selectedAmountIncluded'],
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
            item_status: this.selectedItemStatus,
            amount_included: this.selectedAmountIncluded,
            keyword: this.searchedKeyword,
            url: 'dashboard.supply-order.index',
            reportUrl: 'dashboard.getSupplyOrderReports',
            reportName: 'Generate Supply Order Reports',
            params: {
                company: this.selectedCompany,
                status: this.selectedStatus,
                startDate: this.selectedStartDate,
                endDate: this.selectedEndDate,
                limit: this.selectedLimit,
                department: this.selectedDepartment,
                currency: this.selectedCurrency,
                item_status: this.selectedItemStatus,
                amount_included: this.selectedAmountIncluded,
            },
            selectedFilters: [
                'company',
                'status',
                'start_date',
                'end_date',
                'limit',
                'department',
                'currency',
                'item_status',
                'amount_included'
            ],
        }
    },
    methods: {
        edit($id){
            this.$inertia.get(route('dashboard.supply-order.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        show($id){
            this.$inertia.get(route('dashboard.supply-order.show', $id), {
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
                    this.$inertia.delete(route('dashboard.supply-order.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
        addDeliveryChallan(id) {
            this.$inertia.get(route('dashboard.delivery-challan.create'), {supply_order_id: id}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        showDeliveryChallan(id) {
            this.$inertia.get(route('dashboard.supply-order.show', id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        }
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
                this.params.item_status = args.params.item_status
                this.params.amount_included = args.params.amount_included
            }
        })
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
