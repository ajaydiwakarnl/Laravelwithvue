<template>
  <div class="container" style="margin-top:30px;">
    <div class="row justify-content-center" >
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>
          <div class="card-body">
            <div class="alert  alert-dismissible fade show" role="alert" id="error-block" style="display:none;">
              <strong id="error"> </strong> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="register">
              <div class="form-group">
                <label for="first_name"> First Name</label>
                <input type="text" v-model="first_name" class="form-control" name="first_name" placeholder="first name">
              </div>

              <div class="form-group">
                <label for="last_name"> Last Name</label>
                <input type="text" v-model="last_name" class="form-control" name="last_name" placeholder="last name">
              </div>

              <div class="form-group">
                <label for="email"> Email Address</label>
                <input type="email" v-model="email" class="form-control" name="email" placeholder="Email Address">
              </div>

              <div class="form-group">
                <label for="password"> Password</label>
                <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
              </div>

              <button class="btn btn-primary ">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import axios from 'axios'
  import router from '../router'

  export default{
    data(){
      return {
          first_name: '',
          last_name: '',
          email: '',
          password: '',
      }
    },
    methods:{
      register() {
          axios.post('/api/register',{
              name:this.first_name +' '+ this.last_name,
              email:this.email,
              password:this.password,
          }).then((res) => {
            console.log(res)
            if(res.data.code == 422){ 
            
              $('#error-block').show()
              $('#error-block').addClass("alert-danger")
              $('#error').text(res.data.message)
            }else if(res.data.code == 201){
             
              $('#error-block').show()
              $('#error-block').addClass("alert-success")
              $('#error').text(res.data.message)
              router.push({name: 'Login'})
            }
            
          
          }).catch((err) => {
              console.log(err)
          })

      }
    }

  }
</script>