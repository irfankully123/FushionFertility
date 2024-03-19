<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const globalProps=usePage().props;

const user = computed(() => usePage().props.auth)

const updateInertiaRootClass=()=> {
    const dynamicClass = 'layout-menu-expanded';
    document.documentElement.classList.add(dynamicClass);
}

</script>

<template>
    <nav id="nav"
         class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" id="customButton"  @click="updateInertiaRootClass">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item lh-1 me-3">
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img v-if="user.profile!==null" :src="`/storage/users/${user.profile}`" alt="UserProfile"
                                 class="w-px-40 h-auto rounded-circle"/>
                            <img v-else src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="Placeholder" class="w-px-40 h-auto rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img v-if="user.profile!==null" :src="`/storage/users/${user.profile}`"
                                                 alt="UserProfile" class="w-px-40 h-auto rounded-circle"/>
                                            <img v-else src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="Placeholder"
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ globalProps.auth.name }}</span>
                                        <small v-if="globalProps.super_admin" class="text-muted">
                                            {{ globalProps.super_admin && 'Super Admin' }}
                                        </small>
                                        <small v-if="admin" class="text-muted">
                                            {{ globalProps.admin && 'Admin' }}
                                        </small>
                                        <small v-if="doctor" class="text-muted">
                                            {{ globalProps.doctor && 'Doctor' }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <Link :href="route('dashboard.auth.show')" class="dropdown-item">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </Link>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/">
                                <i class='bx bx-home me-2'></i>
                                <span class="align-middle">Website</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
