<template>
  <div class="container" style="margin-top:30px;">
    <div class="row justify-content-center" >
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Profile</div>
          <div class="card-body">
           <table class="table">
              <tbody>
                <tr>
                  <td>Name</td>
                  <td>{{wholename}}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>{{email}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
    import axios from 'axios'
    export default{
      data() {
        this.getUser().then(res => {
          this.wholename = res.data.name
          this.email = res.data.email

          return res
        })
        return {
          wholename: '',
          email: ''
        }
      },
      methods: {
        
        getUser() {
      
          return axios.get('api/profile', {
            headers:{
              Authorization: 'Bearer '+ localStorage.usertoken
            }
              
          }).then(res => {
            
            return res.data

          }).catch(err => {
             console.log(err)
          })

        }

      }
    }
</script>