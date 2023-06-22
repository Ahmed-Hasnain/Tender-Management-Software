<template>
    <Head title="Add Supply Order" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Supply Order</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="date">Date of Supply Order:</label>
                                <Datepicker v-model="form.date_of_supply_order" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.date_of_supply_order"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="date">Delivery Date:</label>
                                <Datepicker v-model="form.delivery_date" :enable-time-picker="false"></Datepicker>
                                <error :message="form.errors?.delivery_date"></error>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold" for="status">Status:</label>
                                <select class="form-control" v-model="form.status">
                                    <option value="pending" class="text-capitalize">Pending</option>
                                    <option value="processing" class="text-capitalize">Processing</option>
                                    <option value="completed" class="text-capitalize">Completed</option>
                                </select>
                                <error :message="form.errors?.status"></error>
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
                            <div class="table-responsive" v-if="quotation_items.length > 0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 50px;"></th>
                                            <th scope="col" style="width: 300px;">Name</th>
                                            <th scope="col" style="width: 100px;">Unit</th>
                                            <th scope="col" style="width: 100px;">Quantity</th>
                                            <th scope="col" style="width: 100px;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in quotation_items" :key="index">
                                            <td scope="row">
                                                <input type="checkbox" class="form-control" id="status" v-model="form.items[index].status" style="height: 25px;">
                                            </td>
                                            <td class="text-capitalize">{{ item.tender_item?.item?.name }}<br><small>{{ item.tender_item?.description }}</small></td>
                                            <td class="text-capitalize">{{ item.tender_item?.unit?.full_name }}</td>
                                            <td class="text-capitalize">
                                                <input type="number" step="0.01" class="form-control" id="qty"
                                                placeholder="qty" v-model="form.items[index].qty" required>
                                            </td>
                                            <td class="text-capitalize">
                                                <input type="number" step="0.01" class="form-control" id="name"
                                                placeholder="Unit Price" v-model="form.items[index].unit_price"
                                                :class="{ 'is-invalid': form.errors?.reference_no }" required>
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
    props: ['quotation_items', 'supplyOrder'],
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
            this.form.put(route('dashboard.supply-order.update', this.form.id), {
                errorBag: 'supply-order',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
        addItems() {
            this.quotation_items.forEach((val, index) => {
                this.form.items.push({
                    quotation_item_id: val.id,
                    unit_price: val.unit_price,
                    status: false,
                    qty: val.tender_item.qty,
                })
            })
        },
    },
    mounted() {
        this.form = useForm({
            id: this.supplyOrder ? this.supplyOrder.id : null,
            date_of_supply_order: this.supplyOrder ? this.supplyOrder.date_of_supply_order : null,
            delivery_date: this.supplyOrder ? this.supplyOrder.delivery_date : null,
            status: this.supplyOrder ? this.supplyOrder.status : 'pending',
            items: [],
        })
        this.addItems()
    },
}
</script>

<style>

</style>
