<template>
    <Head title="Edit Unit" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Unit</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="userName">Full Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Full Name" v-model="form.full_name" :class="{'is-invalid' : form.errors?.full_name}">
                                <error :message="form.errors?.full_name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="userName">Short Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Short Name" v-model="form.short_name" :class="{'is-invalid' : form.errors?.short_name}">
                                <error :message="form.errors?.short_name"></error>
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
import Error from '@/Components/InputError.vue'

export default {
    props:['unit'],
    components: {
        AuthenticatedLayout,
        Head,
        Error
    },
    data() {
        return {
            form: null,
        }
    },
    methods: {
        submit(){
            this.form.put(route('dashboard.unit.update', this.form.id), {
                errorBag: 'unit',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
    },
    mounted() {
        this.form = useForm({
            id: this.unit ? this.unit.id : null,
            full_name: this.unit ? this.unit.full_name : null,
            short_name: this.unit ? this.unit.short_name : null,
        })
    },
}
</script>

<style>

</style>
