<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Novus Logics</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse justify-content-end" id="navbar1" >
      <ul class="navbar-nav">
        <li v-if="auth==='undefined' " class="nav-item">
          <router-link class="nav-link" to="/">Login</router-link>
        </li>
        <li v-if="auth==='undefined' " class="nav-item">
          <router-link class="nav-link" to="/register">Register</router-link>
        </li>
        <li v-if="auth === 'LoggedIn'" class="nav-item">
          <router-link class="nav-link" to="/profile">Profile</router-link>
        </li>
        <li v-if="auth === 'LoggedIn'" class="nav-item">
          <a class="nav-link" to="" v-on:click.prevent=logout>Logout</a >
        </li>

      </ul>
    </div>
  </nav>
</template>

<script>
    import EventBus from '../components/EventBus'
    import router from '../router'
  
    export default {
      data() {
        return {
          auth: "undefined"
        }
      },
      methods:{
        logout : function(event)  {
          localStorage.removeItem('usertoken')
          this.auth = "undefined";
          router.push({name: 'Login'})
        }
      },
      mounted() {
        console.log(localStorage.usertoken);
        
        if(localStorage.usertoken != "undefined"){
          this.auth =  "LoggedIn";
        }

      }
    
    }

</script>