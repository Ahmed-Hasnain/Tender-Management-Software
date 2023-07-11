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
                                <div id="DataTables_Table_0_filter" class="dataTables_filter" >
                                    <label>
                                        <search :url="'dashboard.tender.index'" :searchedKeyword="searchedKeyword" :params="params"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3 px-3 pb-3 border mt-3 mb-3" >
                            <div class="col-sm-12 col-md-12 px-3">
                                <div class="row">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter" style="text-align: left;">
                                        <label>
                                            <span class="px-2">Company</span> 
                                            <select class="form-control form-control-sm mt-1" v-model="company" @change="applyFilter()">
                                                <option value="null" class="text-capitalize">Select Company</option>
                                                <option value="OndreTicaretTemplate" class="text-capitalize">Ondre Ticaret</option>
                                                <option value="MSaadAndCompanyTemplate" class="text-capitalize">M Saad and Company</option>
                                                <option value="AscentTemplate" class="text-capitalize">Ascent Tech</option>
                                            </select>
                                        </label>
                                        <label class="px-2">
                                            <span class="px-2">Status</span> 
                                            <select class="form-control form-control-sm mt-1" v-model="status" @change="applyFilter()">
                                                <option value="null" class="text-capitalize">Select Status</option>
                                                <option value="pending" class="text-capitalize">pending</option>
                                                <option value="quotation_in_process" class="text-capitalize">quotation in process</option>
                                                <option value="quotation_applied" class="text-capitalize">quotation applied</option>
                                                <option value="quotation_not_applied" class="text-capitalize">quotation not applied</option>
                                                <option value="quotation_not_qualified" class="text-capitalize">quotation not qualified</option>
                                                <option value="expected_order" class="text-capitalize">expected order</option>
                                                <option value="clarification_before_supply_order" class="text-capitalize">clarification before supply order</option>
                                                <option value="validity_extended" class="text-capitalize">validity extended</option>
                                                <option value="purchasing_in_process" class="text-capitalize">purchasing in process</option>
                                                <option value="clarification_after_supply_order" class="text-capitalize">clarification after supply order</option>
                                                <option value="store_purchased" class="text-capitalize">store purchased</option>
                                                <option value="store_delivered" class="text-capitalize">store delivered</option>
                                                <option value="payment_received" class="text-capitalize">payment received</option>
                                                <option value="supply_regretted" class="text-capitalize">supply regretted</option>
                                            </select>
                                        </label>
                                        <label class="">
                                            <span class="px-2 pb-5">Start Date</span> 
                                            <Datepicker v-model="startDate" :enable-time-picker="false" class="pt-1"  @update:model-value="applyFilter()"></Datepicker>
                                        </label>
                                        <label class="">
                                            <span class="px-2 pb-5">End Date</span> 
                                            <Datepicker v-model="endDate" :enable-time-picker="false" class="pt-1" @update:model-value="applyFilter()"></Datepicker>
                                        </label>
                                        <label class="px-2">
                                            <span class="px-2">Limit</span> 
                                            <select class="form-control form-control-sm mt-1" v-model="limit" @change="applyFilter()">
                                                <option value="null" class="text-capitalize">Limit</option>
                                                <option :value="totalTenders" class="text-capitalize">All</option>
                                                <option value="10" class="text-capitalize">10</option>
                                                <option value="20" class="text-capitalize">20</option>
                                                <option value="50" class="text-capitalize">50</option>
                                                <option value="100" class="text-capitalize">100</option>
                                                <option value="200" class="text-capitalize">200</option>
                                                <option value="500" class="text-capitalize">500</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <a :href="route('dashboard.getTenderReports', [tenderIds, company, status, startDate, endDate, limit])" class="btn btn-primary btn-sm" style="width:100%;">Generate Tender Reports</a>
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
                        <pagination :meta="allTenders" :keyword="searchedKeyword" :params="params"></pagination>
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
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search,
        Datepicker
    },
    props: ['tenders', 'searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalTenders', 'tenderIds'],
    data() {
        return{
            allTenders: this.tenders,
            company: this.selectedCompany,
            status: this.selectedStatus,
            startDate: this.selectedStartDate,
            endDate: this.selectedEndDate,
            limit: this.selectedLimit,
            params: {
                company: this.selectedCompany,
                status: this.selectedStatus,
                startDate: this.selectedStartDate,
                endDate: this.selectedEndDate,
                limit: this.selectedLimit,
            }
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
        },
        applyFilter(){
            this.params.company = this.company
            this.params.status = this.status
            this.params.startDate = this.startDate
            this.params.endDate = this.endDate
            this.params.limit = this.limit
            this.$inertia.get(route('dashboard.tender.index'), {params: this.params}, {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
    },
    watch: {
        tenders:{
            handler(tenders) {
                this.allTenders = tenders
            },
            deep: true,
        },
    },
    mounted(){
        console.log(this.tenderIds, 'tender ids');
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
