<template>

    <Head title="Supplier Detail" />
    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-md-flex align-items-center">
                            <div class="text-center text-sm-left">
                                <h2 class="m-b-5 text-capitalize">{{ supplier.name }}</h2>
                                <p class="text-opacity font-size-13">
                                    {{ supplier.website }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Address</h5>
                                <div class="m-t-20">
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.address }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Address</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.city }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">City</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.district }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">District</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.country }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Country</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Bank Info</h5>
                                <div class="m-t-20">
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.bank_name }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Bank Name</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.account_title }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Account Title</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.account_number }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Account Number</span>
                                        </div>
                                    </div>
                                    <div class="media m-b-10">
                                        <div class="avatar avatar-image">
                                            <i class="anticon anticon-check" style="color:black"></i>
                                        </div>
                                        <div class="media-body m-l-20">
                                            <h6 class="m-b-0 text-capitalize">{{ supplier.branch_code }}</h6>
                                            <span class="font-size-13 text-gray text-capitalize">Branch Code</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact People</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <button class="btn btn-primary btn-sm" @click="add()" v-if="checkUserPermissions('add_person')">
                                            <i class="anticon anticon-copyright"></i>
                                            <span>Add Person</span>
                                        </button>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                            <label>Search:
                                                <search :url="'dashboard.supplier.person.search'"
                                                    :searchedKeyword="searchedKeyword" :id="supplier.id"></search>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-hover e-commerce-table dataTable no-footer"
                                            id="DataTables_Table_0" role="grid"
                                            aria-describedby="DataTables_Table_0_info"
                                            v-if="allPeople?.data?.length > 0">
                                            <thead>
                                                <tr role="row">
                                                    <th style="width: 70px;">ID</th>
                                                    <th style="width: 225.188px;">Name</th>
                                                    <th style="width: 225.188px;">Email</th>
                                                    <th style="width: 225.188px;">Company</th>
                                                    <th style="width: 225.188px;">Department</th>
                                                    <th style="width: 225.188px;">Mobile No.</th>
                                                    <th style="width: 225.188px;">Fax No.</th>
                                                    <th class="text-right" style="width: 150px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr role="row" class="odd" v-for="(person, index) in allPeople.data"
                                                    :key="index">
                                                    <td>{{ person.id }}</td>
                                                    <td class="text-capitalize">{{ person.name }}</td>
                                                    <td class="">{{ person.email }}</td>
                                                    <td class="text-capitalize"><a href="#"
                                                            @click="redirect($event, person)">{{
                                                                person.personable?.name
                                                            }}</a></td>
                                                    <td class="text-capitalize">{{ person.department }}</td>
                                                    <td class="text-capitalize">{{ person.mobile_no }}</td>
                                                    <td class="text-capitalize">{{ person.fax }}</td>
                                                    <td class="text-right">
                                                        <button @click="edit(person.personable.id, person.id)"
                                                            class="btn btn-icon btn-hover btn-sm btn-rounded pull-right"
                                                            v-if="checkUserPermissions('edit_person')">
                                                            <i class="anticon anticon-edit"></i>
                                                        </button>
                                                        <button @click="onDelete(person.personable.id, person.id)"
                                                            class="btn btn-icon btn-hover btn-sm btn-rounded"
                                                            v-if="checkUserPermissions('delete_person')">
                                                            <i class="anticon anticon-delete"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div v-else class="pt-3 pl-3">No Data Found.</div>
                                    </div>
                                </div>
                                <pagination :meta="allPeople" :keyword="searchedKeyword" :company_id="supplier.id"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Error from "@/Components/InputError.vue";
import person from "@/Components/person.vue";
import Helpers from '@/Mixins/Helpers';
import pagination from '@/Components/Pagination.vue';
import search from '@/Components/Search.vue';

export default {
    props: ["supplier", "people", "searchedKeyword"],
    components: {
        AuthenticatedLayout,
        Head,
        Error,
        person,
        pagination,
        search
    },
    data() {
        return {
            allPeople: this.people
        };
    },
    methods: {
        add() {
            this.$inertia.get(route('dashboard.company.person.create', this.supplier.id), { type: 'supplier' }, {
                onSuccess: () => { },
                onError: errors => { console.log(errors); }
            })
        },
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
    },
    watch: {
        people: {
            handler(people) {
                this.allPeople = people
                console.log(this.allPeople);
            },
            deep: true,
        },
    },  
    mixins: [Helpers]
};
</script>

<style>

</style>
