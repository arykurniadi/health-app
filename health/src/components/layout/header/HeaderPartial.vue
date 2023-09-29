<template>
  <nav class="navbar navbar-expand navbar-light bg-light sticky-top">
    <div class="container">
      <router-link
        to="/"
        class="navbar-brand"
      >
        # Health App
      </router-link>
      <div class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link
            to="/about"
            class="nav-link"
          >
            About
          </router-link>
        </li>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "HeaderPartial"
}
</script>