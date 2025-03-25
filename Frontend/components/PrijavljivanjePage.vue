<template>
  <section class="forma">
    <div class="hero-content">
      <form id="Radionica" @submit.prevent="prijaviSe">
        <div class="dio">
         <p id="NazivRadionice"><h1 id="Naziv"></h1> </p>
         <p id="OpisRadionice"><h3 id="Opis"></h3> </p>
  
         </div>
        
         
        <hr size="10" width="100%" color="white" />
        
        <div class="dio" id="listaPitanja">
         </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  mounted(){
    this.getRadionica();
  },
  data(){
    return{
      user: [],
      brojPrijave: 0,
    }
  },

  methods: {
    async getRadionica(){
      try {
          await axios.get("http://localhost:8000/Radionica/" + this.$route.query.id).then(res =>{
            document.getElementById("Naziv").innerHTML = res.data.NazivRadionice;
            document.getElementById("Opis").innerHTML = res.data.OpisRadionice;
          })
        } catch (error) {
          this.error = error.response ? error.response.data : error.message
        }
        try{
          await axios.get("http://localhost:8000/SvaPitanja/" + this.$route.query.id).then(res =>{
            res.data.forEach(pitanje=>{
              this.ispisiPitanje(pitanje);
            })
          })
        document.getElementById("listaPitanja").appendChild(document.createElement("div"));
        document.getElementById("listaPitanja").lastChild.innerHTML="<button class='Buttoni' data-v-a81738bd> Prijavi se </button>";
        
        }catch(error){
          this.error = error.response ? error.response.data : error.message
        }
    },
    ispisiPitanje(pitanje){
      let pom = document.getElementById("listaPitanja");
      if(pitanje.VrstaPodatka == "KratkiOdgovor"){
        pom.appendChild(document.createElement("div"));
        pom.lastChild.innerHTML="<h3 id='KratkiOdgovor'> " + pitanje.NazivPitanja + " <br/></h3><textarea id='odgovor':class='{'textarea-custom-width':true,'h-auto':true}'@input='adjustHeight'class='resize-none overflow-hidden p-2 border rounded-md shadow-sm focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50'></textarea>";
        pom.lastChild.childNodes[1].style.width = '50%';
      }
      else if(pitanje.VrstaPodatka == "ViseTocnih"){
        pom.appendChild(document.createElement("div"));
        let popisPitanja = pitanje.OpcijePitanja.split(";");
        let stringOpcija = "<h3 id='ViseTocnih'>" + pitanje.NazivPitanja + "</h3>";
        popisPitanja.forEach((opcija) => {
          stringOpcija += "<input type='checkbox' name='option" + pitanje.id + "' value='" + opcija + "'><label for='option" + pitanje.id + "'>" + opcija + "</label><br/>"
        })
        pom.lastChild.innerHTML = stringOpcija;
      }
      else if(pitanje.VrstaPodatka == "JedanOd"){
        pom.appendChild(document.createElement("div"));
        let popisPitanja = pitanje.OpcijePitanja.split(";");
        let stringOpcija = "<h3 id='JedanOd'>" + pitanje.NazivPitanja + "</h3>";
        popisPitanja.forEach((opcija) => {
          stringOpcija += "<input type='radio' name='option" + pitanje.id + "' value='" + opcija + "'><label for='option" + pitanje.id + "'>" + opcija + "</label><br/>"
        })
        pom.lastChild.innerHTML = stringOpcija;
      }
    },
    async prijaviSe(){
      try{
        await axios.post("http://localhost:8000/ListaPrijava",{
          "IdKreatora": this.user.id,
          "IdRadionice": this.$route.query.id,
        }).then(res => {
          this.brojPrijave = res.data;
        })
        Array.from(document.getElementById("listaPitanja").childNodes).forEach(pitanje =>{
          this.unesiPodatak(pitanje);
        });
      }catch(error){console.log(error);}
    },
    unesiPodatak(pitanje){
      if(pitanje.firstChild.id == "KratkiOdgovor"){
        try{
          axios.post("http://localhost:8000/KorisnikPodatak", {
            "IdPrijave": this.brojPrijave,
            "Odgovor": pitanje.childNodes[1].value,
          })
        }catch(error){console.log(error);}
      }
      else if (pitanje.firstChild.id === "JedanOd") {
    let selectedValue = null;
    
    Array.from(pitanje.childNodes).forEach(child => {
      if (child.tagName === "INPUT" && child.type === "radio" && child.checked) {
        selectedValue = child.value;
      }
    });
    console.log(this.brojPrijave);
    if (selectedValue !== null) {
      try {
        axios.post("http://localhost:8000/KorisnikPodatak", {
          "IdPrijave": this.brojPrijave,
          "Odgovor": selectedValue,
        });
      } catch (error) {
        console.log(error);
      }
    }
    }
    else if (pitanje.firstChild.id === "ViseTocnih") {
    let selectedValues = [];
    // Find all selected checkboxes
    Array.from(pitanje.childNodes).forEach(child => {
      if (child.tagName === "INPUT" && child.type === "checkbox" && child.checked) {
        selectedValues.push(child.value);
      }
    });

    if (selectedValues.length > 0) {
      try {
        axios.post("http://localhost:8000/KorisnikPodatak", {
          "IdPrijave": this.brojPrijave,
          "Odgovor": selectedValues.join(";"), // Join selected values with a delimiter if needed
        });
      } catch (error) {
        console.log(error);
      }
    } else {
      console.log("No checkboxes selected");
    }
  }
    }
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