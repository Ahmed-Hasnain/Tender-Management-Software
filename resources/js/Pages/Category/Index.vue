<template>

    <Head title="Categories" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Categories</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <button class="btn btn-primary btn-sm" @click="addUser()" v-if="checkUserPermissions('add_category')">
                                    <i class="anticon anticon-appstore"></i>
                                    <span>Add Category</span>
                                </button>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.category.index'" :searchedKeyword="searchedKeyword"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allCategories?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 70px;">ID</th>
                                            <th style="width: 225.188px;">Name</th>
                                            <th style="width: 128.688px;">Parent</th>
                                            <th class="text-right" style="width: 96.0125px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(category,index) in allCategories.data" :key="index">
                                            <td>{{ category.id }}</td>
                                            <td class="text-capitalize">{{ category.name }}</td>
                                            <td class="text-capitalize">{{ category.parent ?  category.parent.name : 'null'}}</td>
                                            <td class="text-right">
                                                <button @click="editUser(category.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_category')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(category.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_category')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allCategories" :keyword="searchedKeyword"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Helpers from '@/Mixins/Helpers';
import pagination from '@/Components/Pagination.vue';
import search from '@/Components/Search.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        pagination,
        search
    },
    props: ['categories', 'searchedKeyword'],
    data() {
        return{
            allCategories: this.categories
        }
    },
    methods: {
        addUser(){
            this.$inertia.get(route('dashboard.category.create'), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        editUser($id){
            this.$inertia.get(route('dashboard.category.edit', $id), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        onDelete($id) {
            this.swal.fire({
                title: "",
                html: "<h1 class='text-lg text-gray-800 mb-1'>Delete Record</h1><p class='text-base'>Are you sure want to delete this record?</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Delete Record",
                customClass: {
                confirmButton: 'danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('dashboard.category.destroy', $id), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        }
    },
    watch: {
        categories:{
            handler(categories) {
                this.allCategories = categories
            },
            deep: true,
        },
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
