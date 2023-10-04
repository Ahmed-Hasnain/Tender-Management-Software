<template>
    <modal>
        <template #header>
            <h5 class="modal-title" id="exampleModalLongTitle">Add Tender Item</h5>
        </template>
        <template #content>
            <form @submit.prevent="submit">
                <div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Bank Name">Item</label>
                            <select id="language" class="form-control">
                                <option v-for="(item, index) in sortedItems" :key="index" :value="item.id"
                                    class="text-capitalize">{{ item.name }}</option>
                            </select>
                            <!-- <error :message="form.errors?.item_id"></error> -->
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Account Title">Unit</label>
                            <select id="language" class="form-control">
                                <option v-for="(unit, index) in sortedUnits" :key="index" :value="unit.id"
                                    class="text-capitalize">{{ unit.full_name }}</option>
                            </select>
                            <!-- <error :message="form.error?.unit_id"></error> -->
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Account Title">Quantity</label>
                            <input type="number" class="form-control" placeholder="Quantity">
                            <!-- <error :message="form.errors?.qty"></error> -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold" for="description">Item Description:</label>
                            <textarea class="form-control" rows="3"></textarea>
                            <!-- <error :message="form.errors?.description"></error> -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <button class="btn btn-primary m-t-30 ">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/InputError.vue';
export default {
    props: ['tender_id', 'temder_item'],
    components: {
        Modal,
        Head,
        Error,
    },
    methods: {
        submit() {
            if(this.tenderItem) {
                this.form.put(route('dashboard.tender.update', this.form.id), {
                    errorBag: 'tender',
                    preserveScroll: true,
                    onSuccess: () => { },
                    onError: errors => { console.log(errors); }
                })
            } else {
                this.form.post(route('dashboard.tender.store'), {
                    errorBag: 'tender',
                    preserveScroll: true,
                    onSuccess: () => { },
                    onError: errors => { console.log(errors); }
                })
            }
        },
    },
    data() {
        return {
            form: null,
            tenderItem: this.tender_item,
        }
    },
    mounted() {
        this.form = useForm({
            id: this.tenderItem ? this.tenderItem.id : null,
            unit_id: this.tenderItem ? this.tenderItem.unit_id : null,
            qty: this.tenderItem ? this.tenderItem.qty : null,
            description: this.tenderItem ? this.tenderItem.description : null,
        })
    },
    computed: {
        sortedUnits() {
            return this.$page.props.units.sort((a, b) => {
                return a.full_name.localeCompare(b.full_name);
            });
        },
        sortedItems() {
            return this.$page.props.items.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
        }
    }
}
</script>

<style></style>