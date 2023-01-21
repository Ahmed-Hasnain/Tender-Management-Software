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
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard')">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.user.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-team"></i>
                        </span>
                        <span class="title">Users</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.category.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-appstore"></i>
                        </span>
                        <span class="title">Categories</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.item.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-shopping-cart"></i>
                        </span>
                        <span class="title">Items</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.mode-of-payment.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar"></i>
                        </span>
                        <span class="title">Mode of Payments</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.demand.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-usb"></i>
                        </span>
                        <span class="title">Type of Demands</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.unit.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-deployment-unit"></i>
                        </span>
                        <span class="title">Units</span>
                    </Link>
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.supplier.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-user-add"></i>
                        </span>
                        <span class="title">Suppliers</span>
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

</style>