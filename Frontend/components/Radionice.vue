<template>
    <section class="forma">
      <div class="button-container">
      <button class="hero-button" @click="showInfo(1)">Otvorene prijave</button>
      <button class="hero-button" @click="showInfo(2)">Zatvorene prijave</button>
      <button class="hero-button" @click="showInfo(3)">Moje prijave</button>
    </div>
      <div class="hero-content">
        <table border="3px">
          <thead>
            <th>Naziv radionice</th>
            <th>Ime voditelja</th>
            <th>Rok za prijave</th>
            <th>Datum pocetka</th>
            <th>Datum zavrsetka</th>
            <th>Upravljanje</th>
          </thead>
          <tbody id="tijelo1" v-if="selectedButton === 1">
            
          </tbody>
          <tbody id="tijelo1" v-if="selectedButton === 2">
            
          </tbody>
          <tbody id="tijelo1" v-if="selectedButton === 3">
            
          </tbody>
        </table>
      </div>
    </section>
  </template>
  
  
  
  <script>
  import axios from 'axios';
  axios.defaults.withCredentials = true;
  
  export default {
    data(){
      return {
      selectedButton: 1,
      user: [],
      }
    },
    mounted(){
      this.getRadionice();
    },
  
    methods: {
      async getRadionice(){
        try{
          await axios.get("http://localhost:8000/Radionica").then(res => {
            res.data.forEach(radionica => {
              let lokalno = new Date();
              let vrijemeRadionice = new Date(radionica.PrijaveDo);
              if(this.selectedButton == 1){if(vrijemeRadionice > lokalno)this.ispisiRadionicu(radionica);}
              else if(this.selectedButton == 2){if(vrijemeRadionice < lokalno)this.ispisiRadionicu(radionica);}
              else if(this.selectedButton == 3){if(radionica.IdKreatora == this.user.id)this.ispisiRadionicu(radionica);}
            })
          })
          
        }
        catch(error){
          console.log(error);
        }
  
      },
      async ispisiRadionicu(radionica){
        document.getElementById("tijelo1").appendChild(document.createElement("tr"));
        document.getElementById("tijelo1").lastChild.innerHTML = `<td>${radionica.NazivRadionice}</td><td>${radionica.VoditeljRadionice}</td><td>${radionica.PrijaveDo}</td><td>${radionica.DatumPocetka}</td><td>${radionica.DatumZavrsetka}</td><td><button class='Buttoni' data-v-bd5a589d>Prijavi se</button></td>`;
        if(radionica.IdKreatora == this.user.id){document.getElementById("tijelo1").lastChild.innerHTML += "<td><button class='Buttoni' data-v-bd5a589d>X</button></td>";
        document.getElementById("tijelo1").lastChild.lastChild.previousSibling.firstChild.addEventListener("click", () => this.prijavi(radionica.id));
        document.getElementById("tijelo1").lastChild.lastChild.firstChild.addEventListener("click", () => this.izbrisi(radionica.id));}
        else document.getElementById("tijelo1").lastChild.lastChild.firstChild.addEventListener("click", () => this.prijavi(radionica.id));
      },
      async prijavi(id){
        navigateTo('/opisradionice?id='+id);
      },
      async izbrisi(id){
        if(confirm("Jeste li sigurni da želite izbrisati ovu radionicu?")){
        try{
          axios.get("http://localhost:8000/SvePrijave/"+id).then(res => {
            res.data.forEach(prijava => {
              axios.get("http://localhost:8000/SviPodaci/"+prijava.id).then(resp => {
                resp.data.forEach(podatak => {
                  axios.delete("http://localhost:8000/KorisnikPodatak/"+podatak.id)
                })
                axios.delete("http://localhost:8000/ListaPrijava/"+prijava.id);
              })
            })
          })
          axios.get("http://localhost:8000/SvaPitanja/"+id).then(res => {
            res.data.forEach(pitanje => {
              axios.delete("http://localhost:8000/pitanjaRadionice/"+pitanje.id);
            });
            axios.delete("http://localhost:8000/Radionica/"+id);
          });
        }catch(error){console.log(error);}}
      },
      showInfo(buttonNumber) {
        this.selectedButton = buttonNumber;
        document.getElementById("tijelo1").innerHTML = "";
        this.getRadionice();
      }
    },
      
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
  
.hero-button {
  background-color: rgba(16, 29, 47, 0.83);
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 10px;
  font-size: 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 25%;
  max-width: 140px;
}

.hero-button:hover {
  background-color: rgba(16, 28, 44, 0.9);
}
  </style>