<template>
    <Head title="Add Payment" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Tender</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Cheque No">Cheque No:</label>
                                <input type="text" class="form-control" placeholder="Enter Cheque No" v-model="form.cheque_no" :class="{'is-invalid' : form.errors?.cheque_no}">
                                <error :message="form.errors?.cheque_no"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="cheque_amount">Cheque Amount</label>
                                <input type="text" class="form-control" id="cheque_amount" placeholder="Enter Cheque Amount" v-model="form.cheque_amount" :class="{'is-invalid' : form.errors?.cheque_amount}">
                                <error :message="form.errors?.cheque_amount"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Income Tax Amount">Income Tax Amount:</label>
                                <input type="text" class="form-control" placeholder="Enter Income Tax Amount" v-model="form.income_tax_amount" :class="{'is-invalid' : form.errors?.income_tax_amount}">
                                <error :message="form.errors?.income_tax_amount"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="gst_withhold_amount">GST Withhold Amount</label>
                                <input type="text" class="form-control" id="gst_withhold_amount" placeholder="Enter GST Withhold Amount" v-model="form.gst_withhold_amount" :class="{'is-invalid' : form.errors?.gst_withhold_amount}">
                                <error :message="form.errors?.gst_withhold_amount"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="serial_no">Serial Number</label>
                                <input type="text" class="form-control" id="serial_no" placeholder="Enter Serial Number" v-model="form.serial_no" :class="{'is-invalid' : form.errors?.serial_no}">
                                <error :message="form.errors?.serial_no"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="bank">Bank Name:</label>
                                <select id="language" class="form-control" v-model="form.bank_name" :class="{'is-invalid' : form.errors?.bank_name}">
                                    <option v-for="(bank, index) in banks" :value="bank" :key="index" class="text-capitalize">
                                        {{ removeDashesAndcapitalize(bank) }}
                                    </option>
                                </select>
                                <error :message="form.errors?.bank_name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="Category">Status</label>
                                <select id="language" class="form-control" v-model="form.status" :class="{'is-invalid' : form.errors?.status}">
                                    <option value="pending" class="text-capitalize">Pending</option>
                                    <option value="processing" class="text-capitalize">Processing</option>
                                    <option value="completed" class="text-capitalize">Completed</option>
                                </select>
                                <error :message="form.errors?.status"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="payment_date">Payment Date:</label>
                                <Datepicker v-model="form.payment_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.payment_date"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="cheque_date">Cheque Date:</label>
                                <Datepicker v-model="form.cheque_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.cheque_date"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-11">
                            </div>
                            <div class="form-group col-md-1 text-left">
                                <button class="btn btn-primary m-t-30 " :disabled="form.processing" :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary m-t-30'">Submit</button>
                            </div>
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
import Error from '@/Components/InputError.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Helpers from '@/Mixins/Helpers';

export default {
    props:['supplyOrderId'],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        Datepicker
    },
    data() {
        return {
            form: null,
            banks: [
                'state_bank_of_pakistan',
                'national_bank_of_pakistan',
                'habib_bank_limited_(hbl)',
                'united_bank_limited_(ubl)',
                'mcb_bank_limited',
                'allied_bank_limited_(abl)',
                'bank_alfalah_limited',
                'sindh_bank_limited',
                'askari_bank_limited',
                'faysal_bank_limited',
                'bank_of_punjab_(bop)',
                'habib_metropolitan_bank',
                'soneri_bank_limited',
                'bank_al-habib_limited',
                'standard_chartered_bank_(pakistan)',
                'js_bank_limited',
                'summit_bank_limited',
                'bankislami_pakistan_limited',
                'silk_bank_limited',
                'meezan_bank_limited'
            ],
        }
    },
    methods: {
        submit(){
            this.form.supply_order_id = this.supplyOrderId
            this.form.post(route('dashboard.payment-recieving.store'), {
                errorBag: 'tender',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
    },
    mounted() {
        this.form = useForm({
            supply_order_id: null,
            payment_date: null,
            cheque_no: null,
            bank_name: 'habib_bank_limited_(hbl)',
            cheque_amount: null,
            income_tax_amount: null,
            gst_withhold_amount: null,
            cheque_date: null,
            serial_no: null,
            status : 'pending',
        })
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
