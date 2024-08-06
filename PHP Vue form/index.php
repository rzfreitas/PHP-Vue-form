<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP| MySQL | Vue.js | Axios</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
</head>
<body>

<div id='vueapp'>
    <div class="container mt-5 mb-5">
        <div class="mt-5 mb-5">
            <img src="https://www.teknisa.com/wp-content/uploads/2024/01/logo-teknisa-200x38.webp">
        </div>
        <h1>Contatos</h1>
        <table class="table table-bordered table-striped" border='1' width='100%' style='border-collapse: collapse;'>
           <tr>
             <th>Nome</th>
             <th>Email</th>
             <th>País</th>
             <th>Cidade</th>
             <th>Cargo</th>
             
           </tr>

           <tr v-for='contact in contacts'>
             <td>{{ contact.name }}</td>
             <td>{{ contact.email }}</td>
             <td>{{ contact.country }}</td>
             <td>{{ contact.city }}</td>
             <td>{{ contact.job }}</td>
           </tr>
         </table class="table table-bordered table-striped">
         </br>

        <form>
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control"  type="text" name="name" v-model="name">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email" v-model="email">
          </div>
          <div class="form-group">
            <label>País</label>
            <input class="form-control" type="text" name="country" v-model="country">
          </div>
          <div class="form-group">
            <label>Cidade</label>
            <input class="form-control" type="text" name="city" v-model="city">
          </div>
          <div class="form-group">
            <label>Cargo</label>
            <input class="form-control" type="text" name="job" v-model="job">
          </div>
          <input type="button" class="btn btn-success btn-xs" @click="createContact()" value="Adicionar">
        </form>
    </div>
</div>
<script>
var app = new Vue({
  el: '#vueapp',
  data: {
      name: '',
      email: '',
      country: '',
      city: '',
      job: '',
      contacts: []
  },
  mounted: function () {
    console.log('Hello from Vue!')
    this.getContacts()
  },

  methods: {
    getContacts: function(){
        axios.get('api/contacts.php')
        .then(function (response) {
            console.log(response.data);
            app.contacts = response.data;

        })
        .catch(function (error) {
            console.log(error);
        });
    },

    createContact: function(){
        console.log("Create contact!")

        let formData = new FormData();
        console.log("name:", this.name)
        formData.append('name', this.name)
        formData.append('email', this.email)
        formData.append('city', this.city)
        formData.append('country', this.country)
        formData.append('job', this.job)
        
        var contact = {};
        formData.forEach(function(value, key){
            contact[key] = value;
        });

        axios({
            method: 'post',
            url: 'api/contacts.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            //handle success
            console.log(response)
            app.contacts.push(contact)
            app.resetForm();
        })
        .catch(function (response) {
            //handle error
            console.log(response)
        });
    },
    resetForm: function(){
        this.name = '';
        this.email = '';
        this.country = '';
        this.city = '';
        this.job = '';
    }
  }
})    
</script>    
</body>
</html>