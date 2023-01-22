<template>
    <Head title="Edit Item" />
    <AuthenticatedLayout>
        <form v-if="form" @submit.prevent="submit">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Item</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="userName">Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="User Name" v-model="form.name" :class="{'is-invalid' : form.errors?.name}">
                                <error :message="form.errors?.name"></error>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="language">Category</label>
                                <select id="language" class="form-control" v-model="form.category_id" :class="{'is-invalid' : form.errors?.category_id}" @change="getSubCategories(form.category_id)">
                                    <option v-for="(category,index) in categories" :key="index" :value="category.id" class="text-capitalize">{{ category.name }}</option>
                                </select>
                                <error :message="form.errors?.category_id"></error>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold" for="language">Sub Category</label>
                                <select id="language" class="form-control" v-model="form.sub_category_id" :class="{'is-invalid' : form.errors?.sub_category_id}">
                                    <option v-for="(sub_category,index) in filtered_sub_categories" :key="index" :value="sub_category.id" class="text-capitalize" :disabled="!form.category_id">{{ sub_category.name }}</option>
                                </select>
                                <error :message="form.errors?.sub_category_id"></error>
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
    props:['item', 'categories', 'sub_categories'],
    components: {
        AuthenticatedLayout,
        Head,
        Error
    },
    data() {
        return {
            form: null,
            filtered_sub_categories: this.sub_categories
        }
    },
    methods: {
        submit(){
            this.form.put(route('dashboard.item.update', this.form.id), {
                errorBag: 'item',
                preserveScroll: true,
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        }, 
        getSubCategories(id) {
            this.filtered_sub_categories = this.sub_categories.filter(cat => cat.parent_id == id)
        } 
    },
    mounted() {
        this.form = useForm({
            id: this.item ? this.item.id : null,
            name: this.item ? this.item.name : null,
            category_id: this.item ? this.item.category_id : null,
            sub_category_id: this.item ? this.item.sub_category_id : null,
        })
    },
}
</script>

<style>

</style>
