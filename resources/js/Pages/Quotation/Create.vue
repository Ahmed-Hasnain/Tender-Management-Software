<template>
    <Head title="Add Quotation" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Quotation</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="Name">Reference Number:</label>
                                <input type="text" class="form-control" placeholder="Reference Number"
                                    v-model="form.reference_no" :class="{ 'is-invalid': form.errors?.reference_no }">
                                <error :message="form.errors?.reference_no"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="date">Applied Date:</label>
                                <Datepicker v-model="form.applied_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.applied_date"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="currency">Currency:</label>
                                <select id="language" class="form-control" v-model="form.currency">
                                    <option v-for="(currency, index) in currencies" :key="index"
                                        :value="currency.symbol" class="text-capitalize">{{ currency.name }}</option>
                                </select>
                                <error :message="form.errors?.currency"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="tax">Tax Percentage:</label>
                                <input type="text" class="form-control" placeholder="tax" v-model="form.tax"
                                    :class="{ 'is-invalid': form.errors?.tax }">
                                <error :message="form.errors?.tax"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="status">Status:</label>
                                <select class="form-control" v-model="form.status">
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
                                <error :message="form.errors?.status"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold">Delivery Time:</label>
                                <input type="text" class="form-control" placeholder="Delivery Time"
                                    v-model="form.delivery_time" :class="{ 'is-invalid': form.errors?.delivery_time }">
                                <error :message="form.errors?.delivery_time"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold">Validity of Quotation:</label>
                                <input type="text" class="form-control" placeholder="Validity of Quotation"
                                    v-model="form.validity_of_quotation" :class="{ 'is-invalid': form.errors?.validity_of_quotation }">
                                <error :message="form.errors?.validity_of_quotation"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="terms_and_conditions">Terms and
                                    Conditions:</label>
                                <textarea class="form-control" placeholder="Use full-stop to seperate lines..." rows="2" v-model="form.terms_and_conditions"
                                    :class="{ 'is-invalid': form.errors.terms_and_conditions }"></textarea>
                                <error :message="form.errors?.terms_and_conditions"></error>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Items</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive" v-if="tender_items.length > 0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col" style="width: 250px;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in tender_items" :key="index">
                                            <th scope="row">{{ item.id }}</th>
                                            <td class="">{{ item.item?.name }}<br><small>{{ item.description }}</small></td>
                                            <td class="text-capitalize">{{ item.unit?.full_name }}</td>
                                            <td class="text-capitalize">{{ item.qty }}</td>
                                            <td class="text-capitalize">
                                                <input type="number" step="0.01" class="form-control" id="name"
                                                    placeholder="Unit Price" v-model="form.items[index].unit_price"
                                                    :class="{ 'is-invalid': form.errors?.reference_no }" required>
                                                {{ this.setTenderItemId(item.id, index) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>No record Found</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-11">
                        </div>
                        <div class="form-group col-md-1 text-left">
                            <button class="btn btn-primary m-t-30 " :disabled="form.processing"
                                :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary m-t-30'">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    props: ['tender_items', 'currencies'],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        Datepicker
    },
    data() {
        return {
            form: null,
        }
    },
    methods: {
        submit() {
            this.form.tender_id = this.tender_items[0].tender_id
            this.form.post(route('dashboard.quotation.store'), {
                errorBag: 'quotation',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
        addItems() {
            this.tender_items.forEach((val, index) => {
                this.form.items.push({
                    tender_item_id: null,
                    unit_price: null,
                })
            })
        },
        setTenderItemId(id, index) {
            this.form.items[index].tender_item_id = id
        }
    },
    mounted() {
        this.form = useForm({
            reference_no: null,
            currency: null,
            terms_and_conditions: null,
            tender_id: null,
            items: [],
            tax: null,
            delivery_time: null,
            validity_of_quotation: null,
            status: 'quotation_in_process',
            applied_date: null,
        })
        this.addItems()
    },
}
</script>

<style>

</style>
