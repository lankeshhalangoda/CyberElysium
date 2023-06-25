<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <span class="navbar-text h3 fw-bold">CyberElysium Assignment</span>
  
        <div class="ml-auto">
          <ul class="navbar-nav">
            <li class="nav-item">
              <Link :href="route('profile.edit')" class="nav-link link-success fw-bold">Edit Profile</Link>
            </li>
            <li class="nav-item">
              <Link :href="route('logout')" class="nav-link link-success fw-bold" method="post">Logout</Link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3';
  
  export default {
    components: {
      Link
    }
  };
  </script>
  
  <style scoped>
  </style>
  