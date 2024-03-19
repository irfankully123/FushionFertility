<script setup>
import SideNav from '@/Include/SideNav.vue'
import NavigationBar from '@/Include/NavBar.vue'
import Footer from '@/Include/Footer.vue'
</script>
<template>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <SideNav></SideNav>
            <div class="layout-page">
                <NavigationBar></NavigationBar>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <slot></slot>
                    </div>
                    <Footer></Footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
</template>
