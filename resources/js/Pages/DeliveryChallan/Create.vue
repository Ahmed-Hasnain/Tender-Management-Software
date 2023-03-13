<template>
    <Head title="Add Delivery Challan" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Delivery Challan</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive" v-if="supplyOrderItemsNew.length > 0">
                                <h5>Items Left</h5>
                                <table class="table table-bordered" v-if="supplyOrderItemsNew.length > 0">
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
                                        <tr v-for="(item, index) in supplyOrderItemsNew" :key="index">
                                            <td scope="row">
                                                <input type="checkbox" class="form-control" id="status" v-model="form.items[index].status" style="height: 25px;">
                                            </td>
                                            <td class="text-capitalize">{{ item.quotation_item?.tender_item?.item?.name }}<br><small>{{ item.quotation_item?.tender_item?.description }}</small></td>
                                            <td class="text-capitalize">{{ item.quotation_item?.tender_item?.unit?.full_name }}</td>
                                            <td class="text-capitalize">
                                                <input type="number" step="1" :max="max_limit[index]" min="1" class="form-control" id="qty"
                                                placeholder="qty" v-model="form.items[index].qty" required>
                                            </td>
                                            <td class="text-capitalize">
                                                <input type="number" step="0.01" class="form-control" :value="item.unit_price"
                                                placeholder="Unit Price" :class="{ 'is-invalid': form.errors?.reference_no }" disabled>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="delivery_challan_items.length > 0">
                                <h5>Items Given</h5>
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
                                        <tr v-for="(item, index) in delivery_challan_items" :key="index">
                                            <td scope="row">
                                                {{ item.delivery_challan?.reference_no }}
                                            </td>
                                            <td class="text-capitalize">{{ item.supply_order_item?.quotation_item?.tender_item?.item?.name }}<br><small>{{ item.supply_order_item?.quotation_item?.tender_item?.description }}</small></td>
                                            <td class="text-capitalize">{{ item.supply_order_item?.quotation_item?.tender_item?.unit?.full_name }}</td>
                                            <td class="text-capitalize">{{ item.qty }}</td>
                                            <td class="text-capitalize">{{ item.unit_price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold" for="Remarks">Remarks:</label>
                            <textarea class="form-control" placeholder="Enter Remarks ..." rows="4" v-model="form.description" :class="{ 'is-invalid': form.errors.description }"></textarea>
                            <error :message="form.errors?.description"></error>
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
    props: ['supply_order_items', 'supply_order_id', 'delivery_challan_items'],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        Datepicker
    },
    data() {
        return {
            form: null,
            max_limit: [],
            supplyOrderItemsNew: []
        }
    },
    methods: {
        submit() {
            this.form.post(route('dashboard.delivery-challan.store'), {
                errorBag: 'delivery-challan',
                preserveScroll: true,
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
        addItems() {
            this.supplyOrderItemsNew.forEach((val, index) => {
                this.form.items.push({
                    supply_order_item_id: val.id,
                    unit_price: val.unit_price,
                    qty: val.qty_left,
                    status: false,
                })
                this.maxLimit(val.qty_left, index);
            })
        },
        maxLimit(limit, index){
            this.max_limit[index] = limit
        },  
        supplyOrderItems(){
            this.supplyOrderItemsNew = this.supply_order_items.filter((val, key) => {
                return val.qty_left != 0
            })
        }
    },
    mounted() {
        this.form = useForm({
            description: null,
            supply_order_id: this.supply_order_id,
            delivered: 0,
            items: [],
        })
        this.supplyOrderItems()
        this.addItems()
    },
}
</script>

<style>

</style>
