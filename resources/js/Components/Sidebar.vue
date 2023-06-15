<template>
    <div class="side-nav">
        <div class="side-nav-inner">
            <ul class="side-nav-menu scrollable">
                <!-- <li class="nav-item dropdown open">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Dashboard</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li :class="{ 'active': $page.component === 'Dashboard' }">
                            <Link :href="route('dashboard')">Default</Link>
                        </li>
                        <li :class="{ 'active': $page.component === 'Dashboard2' }">
                            <Link :href="route('dashboard2')">CRM</Link>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item dropdown" :class="{ 'active': dashboardFlag }">
                    <Link :href="route('dashboard')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard" :class="{ 'text-white': dashboardFlag }"></i>
                        </span>
                        <span class="title " :class="{ 'text-white': dashboardFlag }">Dashboard</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': userFlag }">
                    <Link :href="route('dashboard.user.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-team" :class="{ 'text-white': userFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': userFlag }">Users</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': categoryFlag }">
                    <Link :href="route('dashboard.category.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-appstore" :class="{ 'text-white': categoryFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': categoryFlag }">Categories</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': itemFlag }">
                    <Link :href="route('dashboard.item.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-shopping-cart" :class="{ 'text-white': itemFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': itemFlag }">Items</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': mopFlag }">
                    <Link :href="route('dashboard.mode-of-payment.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar" :class="{ 'text-white': mopFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': mopFlag }">Mode of Payments</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': demandFlag }">
                    <Link :href="route('dashboard.demand.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-usb" :class="{ 'text-white': demandFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': demandFlag }">Type of Demands</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': unitFlag }">
                    <Link :href="route('dashboard.unit.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-deployment-unit" :class="{ 'text-white': unitFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': unitFlag }">Units</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': currencyFlag }">
                    <Link :href="route('dashboard.currency.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-euro" :class="{ 'text-white': currencyFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': currencyFlag }">Currencies</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': companyFlag }">
                    <Link :href="route('dashboard.company.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-bank" :class="{ 'text-white': companyFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': companyFlag }">Companies</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': supplierFlag }">
                    <Link :href="route('dashboard.supplier.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-user-add" :class="{ 'text-white': supplierFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': supplierFlag }">Suppliers</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': clientFlag }">
                    <Link :href="route('dashboard.client.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-copyright" :class="{ 'text-white': clientFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': clientFlag }">Clients</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': personFlag }">
                    <Link :href="route('dashboard.company.person.index', 1)" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-contacts" :class="{ 'text-white': personFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': personFlag }">Contact People</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': tenderFlag }">
                    <Link :href="route('dashboard.tender.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-file-protect" :class="{ 'text-white': tenderFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': tenderFlag }">Tenders</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': quotationFlag }">
                    <Link :href="route('dashboard.quotation.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-file-text" :class="{ 'text-white': quotationFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': quotationFlag }">Quotations</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': supplyOrderFlag }">
                    <Link :href="route('dashboard.supply-order.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-audit" :class="{ 'text-white': supplyOrderFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': supplyOrderFlag }">Supply Order</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': deliveryChallanFlag }">
                    <Link :href="route('dashboard.delivery-challan.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-audit" :class="{ 'text-white': deliveryChallanFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': deliveryChallanFlag }">Delivery Challan</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': paymentRecievingFlag }">
                    <Link :href="route('dashboard.payment-recieving.index')" class="custom-menuitem-padding">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar" :class="{ 'text-white': paymentRecievingFlag }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': paymentRecievingFlag }">Payment Recieving</span>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { Head , Link} from '@inertiajs/inertia-vue3';
export default {
    components: {
        Head,
        Link,
    },
    computed: {
        tenderFlag() {
            return this.$page.component === 'Tender/Index' || this.$page.component === 'Tender/Create' || this.$page.component === 'Tender/Edit' || this.$page.component === 'Tender/Show' ? true : false
        },
        clientFlag() {
            return this.$page.component === 'Client/Index' || this.$page.component === 'Client/Create' || this.$page.component === 'Client/Edit' || this.$page.component === 'Client/Show' ? true : false
        },
        supplierFlag() {
            return this.$page.component === 'Supplier/Index' || this.$page.component === 'Supplier/Create' || this.$page.component === 'Supplier/Edit' || this.$page.component === 'Supplier/Show' ? true : false
        },
        unitFlag() {
            return this.$page.component === 'Unit/Index' || this.$page.component === 'Unit/Create' || this.$page.component === 'Unit/Edit' ? true : false
        },
        demandFlag() {
            return this.$page.component === 'Demand/Index' || this.$page.component === 'Demand/Create' || this.$page.component === 'Demand/Edit' ? true : false
        },
        mopFlag() {
            return this.$page.component === 'ModeOfPayment/Index' || this.$page.component === 'ModeOfPayment/Create' || this.$page.component === 'ModeOfPayment/Edit' ? true : false
        },
        itemFlag() {
            return this.$page.component === 'Item/Index' || this.$page.component === 'Item/Create' || this.$page.component === 'Item/Edit' ? true : false
        },
        categoryFlag() {
            return this.$page.component === 'Category/Index' || this.$page.component === 'Category/Create' || this.$page.component === 'Category/Edit' ? true : false
        },
        userFlag() {
            return this.$page.component === 'Users/Index' || this.$page.component === 'Users/Create' || this.$page.component === 'Users/Edit' ? true : false
        },
        dashboardFlag() {
            return this.$page.component === 'Dashboard' || this.$page.component === 'Dashboard' || this.$page.component === 'Dashboard' ? true : false
        },
        personFlag() {
            return this.$page.component === 'Person/Index' || this.$page.component === 'Person/Create' || this.$page.component === 'Person/Edit' ? true : false
        },
        quotationFlag() {
            return this.$page.component === 'Quotation/Index' || this.$page.component === 'Quotation/Create' || this.$page.component === 'Quotation/Edit' || this.$page.component === 'Quotation/Show' ? true : false
        },
        companyFlag() {
            return this.$page.component === 'Company/Index' || this.$page.component === 'Company/Create' || this.$page.component === 'Company/Edit' ? true : false
        },
        currencyFlag() {
            return this.$page.component === 'Currency/Index' || this.$page.component === 'Currency/Create' || this.$page.component === 'Currency/Edit' ? true : false
        },
        supplyOrderFlag() {
            return this.$page.component === 'SupplyOrder/Index' || this.$page.component === 'SupplyOrder/Create' || this.$page.component === 'SupplyOrder/Edit' || this.$page.component === 'SupplyOrder/Show' ? true : false
        },
        deliveryChallanFlag() {
            return this.$page.component === 'DeliveryChallan/Index' || this.$page.component === 'DeliveryChallan/Create' || this.$page.component === 'DeliveryChallan/Edit' || this.$page.component === 'DeliveryChallan/Show' ? true : false
        },
        paymentRecievingFlag() {
            return this.$page.component === 'PaymentRecieving/Index' || this.$page.component === 'PaymentRecieving/Create' || this.$page.component === 'PaymentRecieving/Edit' || this.$page.component === 'PaymentRecieving/Show' ? true : false
        }
    }
}
</script>

<style>
.active {
    background: #3f87f5 !important;
}
.text-white{
    color: white !important;
}
.custom-menuitem-padding{
    padding: 3px 10px !important;
}
</style>