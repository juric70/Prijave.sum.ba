<template>
  <section class="forma">
    <div class="hero-content">
      <button @click="fetchDataAndDownload()" class="Buttoni">Export to Excel</button>
      <table border="3px">
        <thead>
          <th>ID</th>
          <th>Ime</th>
          <th>Prezime</th>
          <th>Email</th>
          <th>Vrsta Korisnika</th>
          <th>Promjeni vrstu korisnika</th>
        </thead>
        <tbody id="tijelo">
          
        </tbody>
      </table>
    </div>
  </section>
</template>



<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
axios.defaults.withCredentials = true;

export default {
  mounted(){
    this.getKorisnici();
  },

  methods: {
    async getKorisnici(){
      try{
        await axios.get("http://localhost:8000/dajKorisnike").then(res => {
          res.data.forEach(korisnik => {
            this.ispisiKorisnika(korisnik);
          })
        })
        
      }
      catch(error){
        console.log(error);
      }

    },
    jsonToCsv(jsonData) {
      const keys = Object.keys(jsonData[0]);
      const csvRows = jsonData.map(row => keys.map(key => `"${row[key]}"`).join(','));
      return `${keys.join(',')} \n${csvRows.join('\n')}`;
      },
    async fetchDataAndDownload() {
  const response = await fetch('http://localhost:8000/SvePrijave/10');
  const data = await response.json();},
    async ispisiKorisnika(korisnik){
      document.getElementById("tijelo").appendChild(document.createElement("tr"));
      document.getElementById("tijelo").lastChild.innerHTML = `<td>${korisnik.id}</td><td>${korisnik.name}</td><td>${korisnik.lastname}</td><td>${korisnik.email}</td><td>${korisnik.vrstaKorisnika}</td><td><button class='Buttoni' data-v-ea3ac3e9>Obican korisnik</button><button class='Buttoni' data-v-ea3ac3e9>Kreator</button><button class='Buttoni' data-v-ea3ac3e9>SuperAdmin</button></td>`;
      let pom3 = document.getElementById("tijelo").lastChild.lastChild.firstChild;
      pom3.addEventListener("click", () => this.obican(korisnik.id));
      pom3 = document.getElementById("tijelo").lastChild.lastChild.childNodes[1];
      pom3.addEventListener("click", () => this.kreator(korisnik.id));
      pom3 = document.getElementById("tijelo").lastChild.lastChild.childNodes[2];
      pom3.addEventListener("click", () => this.SuperAdmin(korisnik.id));
    },
    obican(id) {
      try{
        axios.post("http://localhost:8000/promjeniVrstu/"+id,{
          "vrstaKorisnika": 3,
        }).then(res => {
          alert("Stanje korisnika uspiješno promjenjeno!");
        })
      }catch(error){console.log(error);}
    },
    kreator(id) {
      try{
        axios.post("http://localhost:8000/promjeniVrstu/"+id,{
          "vrstaKorisnika": 2,
        }).then(res => {
          alert("Stanje korisnika uspiješno promjenjeno!");
        })
      }catch(error){console.log(error);}
    },
    SuperAdmin(id) {
      try{
        axios.post("http://localhost:8000/promjeniVrstu/"+id,{
          "vrstaKorisnika": 1,
        }).then(res => {
          alert("Stanje korisnika uspiješno promjenjeno!");
        })
      }catch(error){console.log(error);}
    },    
  }
}

</script>

<style scoped>

  .forma {
    height: 100vh;
    text-align: center;
  }

  .hero-content {
    max-width: 800px;
  }

  table{
    color:white;
    font-size:20px;
    background-color: #014479;
    width: 60vw;
    position: relative;
    left: 20vw;
    top: 5vw;  
    text-align: left;
    line-height: 4vh;
    font-size: 2vh;
    border-radius:12px;
  }

  .Buttoni {
    background-color: #101D2F;
    border-radius: 8px;
    padding: 10px 10px;
    margin: 5px 5px;
    border: none;
    transition: all 0.3s ease;
    color: white;
    cursor: pointer;
    text-align: center;
}

.Buttoni:hover {
  background-color: #080f18;
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

</style>