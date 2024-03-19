<script setup>
import {Link, usePage} from '@inertiajs/vue3'

const globalProps=usePage().props;

const updateInertiaRootClass = () => {
    const dynamicClass = 'layout-menu-expanded';
    document.documentElement.classList.remove(dynamicClass);
}

</script>
<template>
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo mb-3">
                    <span class="app-brand-logo demo">
                        <a href="/">
                        <img :src="globalProps.logo" width="170" alt="web-logo"/>
                        </a>
                    </span>
            <a @click="updateInertiaRootClass"
               class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.home')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/home')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Home</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('dashboard.doctor.home')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/home')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Home</div>
                </div>
            </Link>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">user management</span>
            </li>
            <Link v-if="globalProps.super_admin && globalProps.auth.user_type==='super'" :href="route('dashboard.user')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/user')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Layouts">App Users</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.doctor')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-first-aid"></i>
                    <div data-i18n="Layouts">Doctor</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.patients')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/patients')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div data-i18n="Layouts">Patients</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.appointments')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/appointments')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-alt"></i>
                    <div data-i18n="Layouts">Appointments</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.transactions')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/transactions')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-paypal"></i>
                    <div data-i18n="Layouts">Transactions</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.invoices')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/invoices')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-invision"></i>
                    <div data-i18n="Layouts">Invoices</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.blog.category')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/blog-category')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div data-i18n="Layouts">Blog Category</div>
                </div>
            </Link>
            <Link v-if="globalProps.super_admin || globalProps.admin" :href="route('dashboard.blogs')" class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/blogs')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-blogger"></i>
                    <div data-i18n="Layouts">Blogs</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('doctor_dashboard.appointmentsPaid',globalProps.auth)"
                  class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/paid/appointments')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-alt"></i>
                    <div data-i18n="Layouts">All Appointments</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('doctor_dashboard.appointmentsSchedule',globalProps.auth)"
                  class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/schedule/appointments')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                    <div data-i18n="Layouts">Today's Appointments</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('doctor_dashboard.appointmentsMeeting',globalProps.auth)"
                  class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/meeting/appointments')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bxl-zoom"></i>
                    <div data-i18n="Layouts">Meeting Queue</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('doctor_dashboard.appointmentsHistory',globalProps.auth)"
                  class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/history/appointments')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div data-i18n="Layouts">Appointment History</div>
                </div>
            </Link>
            <Link v-if="globalProps.doctor && globalProps.auth.user_type==='doctor'" :href="route('doctor_dashboard.patients')"
                  class="menu-item"
                  :class="{ 'active': $page.url.startsWith('/dashboard/doctor/patients')}">
                <div class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div data-i18n="Layouts">Your Patients</div>
                </div>
            </Link>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Error">Error</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Under Maintenance">Under Maintenance</div>
                    </a>
                </li>
            </ul>
        </ul>
    </aside>
</template>
