<template>
    <div class="side-nav">
        <div class="side-nav-inner">
            <ul class="side-nav-menu scrollable">
                <li class="nav-item dropdown open">
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
                </li>
                <li class="nav-item dropdown">
                    <Link :href="route('dashboard.user.index')">
                        <span class="icon-holder">
                            <i class="anticon anticon-team"></i>
                        </span>
                        <span class="title">Users</span>
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