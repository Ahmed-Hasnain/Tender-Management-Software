<template>
    <Head title="Contact People" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Contact People</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <!-- <button class="btn btn-primary btn-sm" @click="add()" v-if="checkUserPermissions('add_person')">
                                    <i class="anticon anticon-copyright"></i>
                                    <span>Add Client</span>
                                </button> -->
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>Search:
                                        <search :url="'dashboard.company.person.index'" :searchedKeyword="searchedKeyword" :id="'1'"></search>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover e-commerce-table dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" v-if="allPeople?.data.length > 0">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 70px;">ID</th>
                                            <th style="width: 225.188px;">Name</th>
                                            <th style="width: 225.188px;">Email</th>
                                            <th style="width: 225.188px;">Company</th>
                                            <th style="width: 225.188px;">Department</th>
                                            <th style="width: 225.188px;">Phone No</th>
                                            <th class="text-right" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd" v-for="(person,index) in allPeople.data" :key="index">
                                            <td>{{ person.id }}</td>
                                            <td class="text-capitalize">{{ person.name }}</td>
                                            <td class="">{{ person.email }}</td>
                                            <td class="text-capitalize"><a href="#" @click="redirect($event, person)">{{ person.personable?.name }}</a></td>
                                            <td class="text-capitalize">{{ person.department }}</td>
                                            <td class="text-capitalize">{{ person.mobile_no }}</td>
                                            <td class="text-right">
                                                <button @click="edit(person.personable.id, person.id)" class="btn btn-icon btn-hover btn-sm btn-rounded pull-right" v-if="checkUserPermissions('edit_person')">
                                                    <i class="anticon anticon-edit"></i>
                                                </button>
                                                <button @click="onDelete(person.personable.id, person.id)" class="btn btn-icon btn-hover btn-sm btn-rounded" v-if="checkUserPermissions('delete_person')">
                                                    <i class="anticon anticon-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="pt-3 pl-3">No Data Found.</div>
                            </div>
                        </div>
                        <pagination :meta="allPeople" :keyword="searchedKeyword"></pagination>
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
    props: ['people', 'searchedKeyword'],
    data() {
        return{
            allPeople: this.people
        }
    },
    methods: {
        edit($companyId, $id){
            this.$inertia.get(route('dashboard.company.person.edit', [$companyId, $id]), {
                onSuccess: () => {},
                onError: errors => {console.log(errors);}
            })
        },
        onDelete($companyId, $id) {
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
                    this.$inertia.delete(route('dashboard.company.person.destroy', [$companyId, $id]), {
                        preserveScroll: false,
                        onSuccess: () => {},
                        onError: errors => {console.log(errors);}
                    })
                }
            })
        },
        redirect(e, person) {
            e.preventDefault()
            if (person.personable_type == "App\\Models\\Client") {
                this.$inertia.get(route('dashboard.client.show', person.personable_id), {
                    onSuccess: () => {},
                    onError: errors => {console.log(errors);}
                })
            }
            if (person.personable_type == "App\\Models\\Supplier") {
                this.$inertia.get(route('dashboard.supplier.show', person.personable_id), {
                    onSuccess: () => {},
                    onError: errors => {console.log(errors);}
                })
            }
        }
    },
    watch: {
        people:{
            handler(people) {
                this.allPeople = people
            },
            deep: true,
        },
    },
    mounted() {
    },
    mixins: [Helpers]
}
</script>

<style>

</style>
