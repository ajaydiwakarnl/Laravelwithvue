<template>
    <div class="container" style="margin-top:30px;">
    <div class="row justify-content-center" >
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="alert  alert-dismissible fade show" role="alert" id="error-block" style="display:none;">
              <strong id="error"> </strong> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form v-on:submit.prevent="Login">
           
              <div class="form-group">
                <label for="email"> Email Address</label>
                <input type="email" v-model="email" class="form-control" name="email" placeholder="Email Address">
              </div>

              <div class="form-group">
                <label for="password"> Password</label>
                <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
              </div>

              <button class="btn  btn-primary ">Login</button>
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
    import EventBus from '../components/EventBus'
    
    export default{
        data(){
            return {
                email: '',
                password: '',
            }
        },
        methods:{
            Login() {
                axios.post('/api/login' , {
                    email : this.email,
                    password : this.password,
                
                }).then((res) => {

                if(res.data.code == 422){
                  $('#error-block').show()
                  $('#error-block').addClass("alert-danger")
                  $('#error').text(res.data.message)
                }
                else if(res.data.code == 400){
                  
                  $('#error-block').show()
                  $('#error-block').addClass("alert-danger")
                  $('#error').text(res.data.message)

                }else if(res.data.code == 500){

                  $('#error-block').show()
                  $('#error-block').addClass("alert-danger")
                  $('#error').text(res.data.message)

                }else if(res.data.code == 201){
                  $('#error-block').show()
                  $('#error-block').addClass("alert-success")
                  $('#error').text(res.data.message)

                  localStorage.setItem('usertoken', res.data.token)
                  this.email = ''
                  this.password = ''
                  router.push({name: 'Profile'})
                }

                
              }).catch((err) => {
                  console.log(err)
              })

              this.emitMethod()
            
            },
            emitMethod() {
              EventBus.$emit('logged-in','loggedin')
            }
            
        }
    }

</script>