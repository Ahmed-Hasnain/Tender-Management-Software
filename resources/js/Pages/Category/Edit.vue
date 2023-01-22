<template>
    <Head title="Edit Category" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Category</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="userName">Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="User Name" v-model="form.name" :class="{'is-invalid' : form.errors?.name}">
                                <error :message="form.errors?.name"></error>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold" for="language">Parent</label>
                                <select id="language" class="form-control" v-model="form.parent_id" :class="{'is-invalid' : form.errors?.parent_id}">
                                    <option v-for="(category,index) in categories" :key="index" :value="category.id" class="text-capitalize">{{ category.name }}</option>
                                </select>
                                <error :message="form.errors?.parent_id"></error>
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
    props:['categories', 'category'],
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
            this.form.put(route('dashboard.category.update', this.form.id), {
                errorBag: 'category',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },  
    },
    mounted() {
        this.form = useForm({
            id: this.category ? this.category.id : null,
            name: this.category ? this.category.name : null,
            parent_id: this.category ? this.category.parent_id : null,
        })
    },
}
</script>

<style>

</style>
