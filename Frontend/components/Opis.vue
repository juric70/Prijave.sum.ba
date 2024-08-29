<template>
    <section class="forma">
      <div class="hero-content">
        <form id="Radionica" @submit.prevent="prijaviSe">
          <div class="dio">
           <p id="NazivRadionice"><h1 id="Naziv"></h1> </p>
           <p id="OpisRadionice"><h3 id="Opis"></h3> </p>
    
           </div>
          
           
          <hr size="10" width="100%" color="white" />
          
          <table class="dio" id="listaPitanja">
          </table>
        </form>
      </div>
    </section>
  </template>
  
  <script>
  import axios from 'axios';
  axios.defaults.withCredentials = true;
  
  export default {
    mounted(){
      this.generirajHeader();
      this.getRadionica();
    },
    data(){
      return{
        user: [],
        brojPrijave: 0,
        radionica: [],
      }
    },
  
    methods: {
      async getRadionica(){
        try {
            await axios.get("http://localhost:8000/Radionica/" + this.$route.query.id).then(res =>{
              this.radionica = res;
              document.getElementById("Naziv").innerHTML = res.data.NazivRadionice;
              document.getElementById("Opis").innerHTML = res.data.OpisRadionice;
              if(this.radionica.data.IdKreatora == this.user.id)this.ispisiPrijave();
            })
          } catch (error) {
            this.error = error.response ? error.response.data : error.message
          }
      },
      async ispisiPrijave(){{
        try{
          await axios.get("http://localhost:8000/SvePrijave/"+this.$route.query.id).then(res => {
            res.data.forEach(korisnik => {
              this.ispisiKorisnika(korisnik);
            })
          })
          
        }
        catch(error){
          console.log(error);
        }
  
      }
    },
      async ispisiKorisnika(korisnik){
        try {
      const res = await axios.get("http://localhost:8000/Radionica/" + korisnik.IdRadionice);
      const data = res.data; // Correctly extract data from the response
      const res2 = await axios.get("http://localhost:8000/prikaziKorisnika/" + korisnik.IdKreatora);
      const data2 = res2.data;
      // Append table row and populate with data
      const newRow = document.createElement("tr");
      console.log(data2);
      let pomD = new Date(data2.datumRodjenja);
      newRow.innerHTML = `
        <td>${data2.name} ${data2.lastname}</td>
        <td>${data2.email}</td> <!-- Accessing data correctly -->
        <td>${pomD.toLocaleDateString()}</td>
        <td>
          <button class='Buttoni' data-v-ea3ac3e9>SuperAdmin</button>
        </td>
      `;
  
      document.getElementById("listaPitanja").appendChild(newRow);
      
      newRow.querySelector(".Buttoni:nth-child(1)").addEventListener("click", () => this.konzoliraj(korisnik.id));
    } catch (error) {
      console.log(error);
    }
  },
  async konzoliraj(id){
    navigateTo("/popunjeno?id="+id);
  },
      async generirajHeader(){
          try{
            let{data} = await axios.get("http://localhost:8000/api/user");
            this.user = data;
            this.napraviHeader(data);
          }
          catch(error){
            if(error.response.status == 401){
              document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/login' class='navbar-item' data-v-a81738bd>Login</a>";
              document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/login' class='mobile-nav-item' data-v-a81738bd>Login</a>";
              alert("Morate biti prijavljeni!");
              navigateTo('/');
            }
          }
        },
        async napraviHeader(data){
          switch(data.vrstaKorisnika){
            case 1:
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/korisnici' class='navbar-item' data-v-a81738bd>Korisnici</a>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/korisnici' class='mobile-nav-item' data-v-a81738bd>Korisnici</a>";
            case 2:
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/create' class='navbar-item' data-v-a81738bd>Kreiraj</a>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/create' class='mobile-nav-item' data-v-a81738bd>Kreiraj</a>";
            case 3:
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/prijave' class='navbar-item' data-v-a81738bd>Prijave</a>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/prijave' class='mobile-nav-item' data-v-a81738bd>Prijave</a>";
  
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/logout' class='navbar-item' data-v-a81738bd>Odjavi se</a>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/logout' class='mobile-nav-item' data-v-a81738bd>Odjavi se</a>";
  
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<p class='navbar-item-dva' data-v-a81738bd>Pozdrav, " + data.name + "</p>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<p class='navbar-item-dva' data-v-a81738bd>Pozdrav, " + data.name + "</p>";
            
          }
        },
    }
  }
  
  
  </script>
  
  <style scoped>
  
    .forma {
      height: 100vh;
      background-color: white;
      text-align: center;
    }
  
    .hero-content {
      max-width: 800px;
    }
  
    #Radionica {
      background-color: #014479;
      width: 60vw;
      position: relative;
      left: 20vw;
      top: 5vw;  
      text-align: left;
      line-height: 4vh;
      font-size: 2vh;
      border-radius:16px;
    }
  
    .dugiodgovor {
      width: auto;
      height: auto;
    }
  
    .dio {
      padding: 20px 10px 5px 20px;
      border-radius: 8px;
    }
  
    .textarea-custom-width {
      width: 50%;
    } 
    .Buttoni {
    background-color: #101D2F;
    border-radius: 8px;
    padding: 10px 20px;
    margin: 20px 20px;
    border: none;
    transition: all 0.3s ease;
    color: white;
    cursor: pointer;
    text-align: center;
  }
  
  .Buttoni:hover {
    background-color: #080f18;
  }
  </style>