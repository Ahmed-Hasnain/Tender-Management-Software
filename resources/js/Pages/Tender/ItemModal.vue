<template>
    <modal>
        <template #header>
            <h5 class="modal-title" id="exampleModalLongTitle">{{form?.id ?  'Edit Tender Item' : 'Add Tender Item'}}</h5>
        </template>
        <template #content>
            <form v-if="form" @submit.prevent="submit">
                <div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Bank Name">Item</label>
                            <select id="language" class="form-control" v-model="form.item_id">
                                <option v-for="(item, index) in sortedItems" :key="index" :value="item.id"
                                    class="text-capitalize">{{ item.name }}</option>
                            </select>
                            <error :message="form.errors?.item_id"></error>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Account Title">Unit</label>
                            <select id="language" class="form-control" v-model="form.unit_id">
                                <option v-for="(unit, index) in sortedUnits" :key="index" :value="unit.id"
                                    class="text-capitalize">{{ unit.full_name }}</option>
                            </select>
                            <error :message="form.errors?.unit_id"></error>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold" for="Account Title">Quantity</label>
                            <input type="number" class="form-control" placeholder="Quantity" v-model="form.qty">
                            <error :message="form.errors?.qty"></error>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold" for="description">Item Description:</label>
                            <textarea class="form-control" rows="3" v-model="form.description"></textarea>
                            <error :message="form.errors?.description"></error>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <button class="btn btn-primary m-t-30 " :disabled="form.processing" :classes="form.processing ? 'btn btn-primary is-loading m-r-5' : 'btn btn-primary m-t-30'">
                                <div v-if="form.processing">
                                    <div class="spinner-border text-primary" role="status" >
                                        <span class="visually-hidden"></span>
                                    </div>
                                    <span class="text-dark px-3">Loading...</span>
                                </div>
                                <div v-else>
                                    Submit
                                </div>
                            </button>
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
    components: {
        Modal,
        Head,
        Error,
    },
    methods: {
        submit() {
            if(this.form.id) {
                this.form.put(route('dashboard.tender-item.update', this.form.id), {
                    errorBag: 'tender_item',
                    preserveScroll: true,
                    onSuccess: () => { 
                        // this.emitter.emit('close_modal')
                    },
                    onError: errors => { console.log(errors); }
                })
            } else {
                this.form.post(route('dashboard.tender-item.store'), {
                    errorBag: 'tender_item',
                    preserveScroll: true,
                    onSuccess: () => {
                        // this.emitter.emit('close_modal')
                    },
                    onError: errors => { console.log(errors); }
                })
            }
        },
    },
    data() {
        return {
            form: null,
            tenderItem: null,
        }
    },
    mounted() {
        this.emitter.on('open_modal', (args) => {
            this.tenderItem = args.item ?? null
            this.form = useForm({
                id: this.tenderItem ? this.tenderItem.id : null,
                unit_id: this.tenderItem ? this.tenderItem.unit_id : null,
                item_id: this.tenderItem && this.tenderItem.item ? this.tenderItem.item.id : null,
                qty: this.tenderItem ? this.tenderItem.qty : null,
                description: this.tenderItem ? this.tenderItem.description : null,
                tender_id: args.tender_id ?? null
            })
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