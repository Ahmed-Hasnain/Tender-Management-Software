<template>
    <div class="row pt-3 px-3 pb-3 border mt-3 mb-3">
        <div class="col-sm-12 col-md-12 px-3">
            <div class="row">
                <div id="DataTables_Table_0_filter" class="dataTables_filter" style="text-align: left;">
                    <label class="px-2">
                        <span class="px-2">Company</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="company"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select Company</option>
                            <option value="OndreTicaretTemplate" class="text-capitalize">Ondre Ticaret</option>
                            <option value="MSaadAndCompanyTemplate" class="text-capitalize">M Saad and Company</option>
                            <option value="AscentTemplate" class="text-capitalize">Ascent Tech</option>
                        </select>
                    </label>
                    <label class="px-2">
                        <span class="px-2">Status</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="status"
                            @change="applyFilter()" v-if="type == 'tender' || type == 'quotation'">
                            <option value="" class="text-capitalize">Select Status</option>
                            <option value="pending" class="text-capitalize">pending</option>
                            <option value="quotation_in_process" class="text-capitalize">quotation in process</option>
                            <option value="quotation_applied" class="text-capitalize">quotation applied</option>
                            <option value="quotation_not_applied" class="text-capitalize">quotation not applied</option>
                            <option value="quotation_not_qualified" class="text-capitalize">quotation not qualified</option>
                            <option value="expected_order" class="text-capitalize">expected order</option>
                            <option value="clarification_before_supply_order" class="text-capitalize">clarification before
                                supply order</option>
                            <option value="validity_extended" class="text-capitalize">validity extended</option>
                            <option value="purchasing_in_process" class="text-capitalize">purchasing in process</option>
                            <option value="clarification_after_supply_order" class="text-capitalize">clarification after
                                supply order</option>
                            <option value="store_purchased" class="text-capitalize">store purchased</option>
                            <option value="store_delivered" class="text-capitalize">store delivered</option>
                            <option value="payment_received" class="text-capitalize">payment received</option>
                            <option value="supply_regretted" class="text-capitalize">supply regretted</option>
                        </select>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="status"
                            @change="applyFilter()" v-if="type == 'supplyOrder' || type == 'deliveryChallan' || type == 'invoices'">
                            <option value="" class="text-capitalize">Select Status</option>
                            <option value="pending" class="text-capitalize">Pending</option>
                            <option value="processing" class="text-capitalize">Processing</option>
                            <option value="completed" class="text-capitalize">Completed</option>
                        </select>
                    </label>
                    <label class="">
                        <span class="px-2 pb-5">Start Date</span>
                        <Datepicker v-model="startDate" :enable-time-picker="false" class="pt-1 custom-datepicker"
                            @update:model-value="applyFilter()"></Datepicker>
                    </label>
                    <label class="">
                        <span class="px-2 pb-5">End Date</span>
                        <Datepicker v-model="endDate" :enable-time-picker="false" class="pt-1 custom-datepicker"
                            @update:model-value="applyFilter()"></Datepicker>
                    </label>
                    <label class="px-2">
                        <span class="px-2">Department</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="department"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select Department</option>
                            <option :value="dept.name" class="text-capitalize" v-for="(dept, index) in allDepartments"
                                :key="index">{{ dept.name }}</option>
                        </select>
                    </label>
                    <label class="px-2">
                        <span class="px-2">Limit</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="limit"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Limit</option>
                            <option :value="totalItems" class="text-capitalize">All</option>
                            <option value="10" class="text-capitalize">10</option>
                            <option value="20" class="text-capitalize">20</option>
                            <option value="50" class="text-capitalize">50</option>
                            <option value="100" class="text-capitalize">100</option>
                            <option value="200" class="text-capitalize">200</option>
                            <option value="500" class="text-capitalize">500</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'supplyOrder' || type == 'quotation' || type == 'invoices'">
                        <span class="px-2">Type of demand</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="currency"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select Type of Demand</option>
                            <option value="local" class="text-capitalize">Local</option>
                            <option value="foreign" class="text-capitalize">Foreign</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'invoices'">
                        <span class="px-2">STI Status</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="sti_status"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select STI Status</option>
                            <option value="downloaded" class="text-capitalize">Downloaded</option>
                            <option value="not_downloaded" class="text-capitalize">Not Downloaded</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'invoices'">
                        <span class="px-2">CI Status</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="ci_status"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select CI Status</option>
                            <option value="downloaded" class="text-capitalize">Downloaded</option>
                            <option value="not_downloaded" class="text-capitalize">Not Downloaded</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'invoices'">
                        <span class="px-2">PR Status</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="pr_status"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select PR Status</option>
                            <option value="recieved" class="text-capitalize">Recieved</option>
                            <option value="pending" class="text-capitalize">Pending</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'deliveryChallan'">
                        <span class="px-2">Item Status</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="item_status"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select Item Status</option>
                            <option value="delivered" class="text-capitalize">Delivered</option>
                            <option value="pending" class="text-capitalize">Pending</option>
                        </select>
                    </label>
                    <label class="px-2" v-if="type == 'deliveryChallan'">
                        <span class="px-2">Amount Included</span>
                        <select class="form-control form-control-sm mt-1 custom-select-new" v-model="amount_included"
                            @change="applyFilter()">
                            <option value="" class="text-capitalize">Select Amount Included</option>
                            <option value="amount_included" class="text-capitalize">Amount Included</option>
                            <option value="amount_not_included" class="text-capitalize">Amount Not Included</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row pt-2">
                <a :href="route(reportUrl, reportParams)" class="btn btn-primary btn-sm"
                    style="width:100%;">{{reportName}}</a>
            </div>
        </div>
    </div>
</template>

<script>
import Helpers from '@/Mixins/Helpers';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    components: {
        Datepicker,
    },
    props: ['searchedKeyword', 'selectedCompany', 'selectedStatus', 'selectedStartDate', 'selectedEndDate', 'selectedLimit', 'totalItems', 'selectedDepartment', 'allDepartments', 'url', 'reportUrl', 'ids', 'reportName', 'type', 'selectedCurrency', 'selectedStiStatus', 'selectedCiStatus', 'selectedPrStatus', 'selectedItemStatus', 'selectedAmountIncluded'],
    data() {
        return{
            allTenders: this.tenders,
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
            item_status: this.selectedItemStatus,
            amount_included: this.selectedAmountIncluded,
            keyword: this.searchedKeyword,
            searchedUrl: this.url,
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
                item_status: this.selectedItemStatus,
                amount_included: this.selectedAmountIncluded,
            }
        }
    },
    methods: {
        applyFilter(){
            this.params.company = this.company
            this.params.status = this.status
            this.params.startDate = this.startDate ?? ""
            this.params.endDate = this.endDate ?? ""
            this.params.limit = this.limit
            this.params.department = this.department
            this.params.currency = this.currency
            this.params.sti_status = this.sti_status
            this.params.ci_status = this.ci_status
            this.params.pr_status = this.pr_status
            this.params.item_status = this.item_status
            this.params.amount_included = this.amount_included
            this.emitter.emit('get_filters', {
                params: this.params,
            });
            this.$inertia.replace(route(this.url, {
                    keyword: this.keyword,
                    params: this.params,
                })
            );
        },
    },
    computed: {
        reportParams() {
            let param =  {
                ids: this.ids,
                company: this.company,
                status: this.status,
                start_date: this.startDate,
                end_date: this.endDate,
                limit: this.limit,
                department: this.department,
                currency: this.currency,
                sti_status: this.sti_status,
                ci_status: this.ci_status,
                pr_status: this.pr_status,
                item_status: this.item_status,
                amount_included: this.amount_included,
            }
            return JSON.stringify(param)
        }
    },
    watch: {
        searchedKeyword:{
            handler(val){
                this.keyword = val;
            },
            deep: true
        },
    },
    mixins: [Helpers]
}
</script>

<style>
.custom-select-new{
    max-width: 200px !important;
    min-width: 200px !important;
}
.custom-datepicker{
    max-width: 2000px !important;
}
.custom-datepicker input{
    max-width: 200px !important;
    min-width: 200px !important;
}
</style>