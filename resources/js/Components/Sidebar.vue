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
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Dashboard' }">
                    <Link :href="route('dashboard')">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard" :class="{ 'text-white': $page.component === 'Dashboard' }"></i>
                        </span>
                        <span class="title " :class="{ 'text-white': $page.component === 'Dashboard' }">Dashboard</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Users/Index' }">
                    <Link :href="route('dashboard.user.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-team" :class="{ 'text-white': $page.component === 'Users/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Users/Index' }">Users</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Category/Index' }">
                    <Link :href="route('dashboard.category.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-appstore" :class="{ 'text-white': $page.component === 'Category/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Category/Index' }">Categories</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Item/Index' }">
                    <Link :href="route('dashboard.item.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-shopping-cart" :class="{ 'text-white': $page.component === 'Item/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Item/Index' }">Items</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'ModeOfPayment/Index' }">
                    <Link :href="route('dashboard.mode-of-payment.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar" :class="{ 'text-white': $page.component === 'ModeOfPayment/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'ModeOfPayment/Index' }">Mode of Payments</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Demand/Index' }">
                    <Link :href="route('dashboard.demand.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-usb" :class="{ 'text-white': $page.component === 'Demand/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Demand/Index' }">Type of Demands</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Unit/Index' }">
                    <Link :href="route('dashboard.unit.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-deployment-unit" :class="{ 'text-white': $page.component === 'Unit/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Unit/Index' }">Units</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Supplier/Index' }">
                    <Link :href="route('dashboard.supplier.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-user-add" :class="{ 'text-white': $page.component === 'Supplier/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Supplier/Index' }">Suppliers</span>
                    </Link>
                </li>
                <li class="nav-item dropdown" :class="{ 'active': $page.component === 'Client/Index' }">
                    <Link :href="route('dashboard.client.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-copyright" :class="{ 'text-white': $page.component === 'Client/Index' }"></i>
                        </span>
                        <span class="title" :class="{ 'text-white': $page.component === 'Client/Index' }">Clients</span>
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
</style>