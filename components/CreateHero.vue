<template>
  <section class="hero">
    <h1> Napravite novu radionicu </h1>
    <div class="hero-content">
      <form id="Radionica" @submit.prevent="submitForm">
        <h2> Osnovne informacije o prijavi: </h2>
        <p id="NazivPrijave">Naziv vaše prijave: <input type="text" placeholder="Unesite naziv..." /></p>
        <p id="DodatneInfo">Dodatne informacije o prijavi: <input type="text" placeholder="Unesite opis..." /></p>
        <p id="Voditelj">Ime i prezime voditelja: <input type="text" placeholder="Unesite voditelja..." /></p>
        <p id="Pocetak">Datum početka: <input class="date" type="date" id="DatPoc"/></p>
        <p id="Zavrsetak">Datum završetka: <input class="date" type="date" id="DatKraj"/></p>
        <p id="RokPrijava">Rok za prijave: <input class="date" type="datetime-local" id="DatPrij"/></p>
        <h2 id="NaslovListe"> Lista pitanja za prijavu: </h2>
          <div class="flex-div">
            <input type='text' class='dugiteksti' placeholder='Unesite naziv pitanja...' />
            <select class='VrstePitanja' @change='promjenaVrste'>
              <option value='KratkiOdgovor'> Kratki Odgovor </option>
              <option value='ViseTocnih'> Vise Tocnih </option>
              <option value='JedanOd'> Jedan Od </option>
            </select>
            <button class="Closer" @click="Destroying">X</button>
          </div>
        <div class="btn-div" id="buttoni">
          <button class="Buttoni" @click="NoviDiv">Dodaj još jedno pitanje</button>
          <button class="Buttoni" @click='Submitting'>Napravi prijavu</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  data() {
    return {
      Radionice: 0,
      ErrorCode: "Niste unijeli sve podatke!",
      User: [],
    };
  },
  mounted(){
    this.generirajHeader();
  },
  methods: {
    async generirajHeader(){
        try{
          let{data} = await axios.get("http://localhost:8000/api/user");
          this.napraviHeader(data);
          this.user = data;
        }
        catch(error){
          if(error.response.status == 401){
            document.getElementsByClassName("navbar-end")[0].innerHTML += "<a href='/login' class='navbar-item' data-v-a81738bd>Login</a>";
            document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/login' class='mobile-nav-item' data-v-a81738bd>Login</a>";
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


    promjenaVrste(event) {
      let e = event.target.parentNode;
      let child = e.childNodes[3];
      while (child) {
        e.removeChild(child);
        child = e.childNodes[3];
      }
      if ((event.target.value == "JedanOd") || (event.target.value == "ViseTocnih")) {
        this.dodajOpciju(e);
      }
    },



    dodajOpciju(e) {
      let pom = e.appendChild(document.createElement("div"));
      pom.appendChild(document.createTextNode("Opcija: "));
      let dodajInput = document.createElement("input")
      dodajInput.style.backgroundColor = 'transparent'
      dodajInput.style.width = 'calc(40% - 20px)'
      dodajInput.style.padding = '10px'
      dodajInput.style.margin = '10px 0'
      dodajInput.style.border = 'none'
      dodajInput.style.borderBottom = '1px solid grey'
      dodajInput.style.transition = 'all 0.3s ease'
      dodajInput.style.color = 'white'
      pom.appendChild(dodajInput);
      let dodajButton2 = document.createElement('button')
      dodajButton2.style.backgroundColor = 'transparent'
      dodajButton2.style.borderRadius = '8px'
      dodajButton2.style.padding = '5px 10px'
      dodajButton2.style.margin = '10px 10px'
      dodajButton2.style.border = '1px solid white'
      dodajButton2.style.transition = 'all 0.3s ease'
      dodajButton2.style.color = 'white'
      dodajButton2.style.cursor = 'pointer'
      dodajButton2.style.textAlign = 'center'
      pom.appendChild(dodajButton2);
      pom.lastElementChild.innerHTML = "Dodaj još jednu opciju";
      pom.lastElementChild.onclick = (event) => {
        event.preventDefault();
        this.dodajOpciju(e);
      };
      let dodajButton = document.createElement("button")
      dodajButton.style.backgroundColor = 'transparent'
      dodajButton.style.borderRadius = '8px'
      dodajButton.style.padding = '5px 10px'
      dodajButton.style.margin = '10px 10px'
      dodajButton.style.border = '1px solid white'
      dodajButton.style.transition = 'all 0.3s ease'
      dodajButton.style.color = 'white'
      dodajButton.style.cursor = 'pointer'
      dodajButton.style.textAlign = 'center'
      pom.appendChild(dodajButton);
      pom.lastElementChild.innerHTML = "Izbriši ovu opciju";
      pom.lastElementChild.onclick = (event) => {
        event.preventDefault();
        e.removeChild(pom);
        if (e.childNodes.length == 3) this.dodajOpciju(e);
      };
    },



    NoviDiv(event) {
      let forma = document.getElementById("Radionica");
      let pom = forma.lastElementChild.previousSibling;
      let pom2 = document.createElement("div");
      pom2.innerHTML = "<input type='text' data-v-0550afab class='dugiteksti' placeholder='Unesite naziv pitanja...'/><select data-v-0550afab class='VrstePitanja'><option data-v-0550afab value='KratkiOdgovor'> Kratki Odgovor </option><option data-v-0550afab value='ViseTocnih'> Vise Tocnih </option><option data-v-0550afab value='JedanOd'> Jedan Od </option></select><button class='Closer' data-v-0550afab @click='Destroying'>X</button>";
      forma.insertBefore(pom2, forma.lastElementChild);

      let selectElement = pom2.querySelector(".VrstePitanja");
      selectElement.addEventListener("change", this.promjenaVrste);
      let pomocni = pom2.querySelector(".Closer");
      pomocni.addEventListener("click", this.Destroying);
    },



    Destroying(event) {
      event.target.parentNode.parentNode.removeChild(event.target.parentNode);
      console.log(document.getElementById("Radionica").lastElementChild.previousSibling);
      if (document.getElementById("Radionica").lastElementChild.previousSibling.id == "NaslovListe") this.NoviDiv();
    },

    async Submitting(event) {
      if(confirm("Jeste li sigurni da ste dobro unijeli podatke?")){
      if(this.provjeraUnosa()){
      try {
          await axios.post('http://localhost:8000/Radionica',{
            "NazivRadionice": document.getElementById("NazivPrijave").childNodes[1].value,
            "OpisRadionice": document.getElementById("DodatneInfo").childNodes[1].value,
            "VoditeljRadionice": document.getElementById("Voditelj").childNodes[1].value,
            "DatumPocetka": document.getElementById("Pocetak").childNodes[1].value,
            "DatumZavrsetka": document.getElementById("Zavrsetak").childNodes[1].value,
            "PrijaveDo": document.getElementById("RokPrijava").childNodes[1].value,
            "IdKreatora": this.user.id,
          }).then(res =>{
            //console.log(res);
          })
        } catch (error) {
          this.error = error.response ? error.response.data : error.message
        }
        await axios.get("http://localhost:8000/Radionica").then(response =>{
          this.Radionice = response.data[response.data.length - 1].id;
        })
        let i = 1;
        while(i == 1){
          i = this.unesiPitanje(document.getElementById("NaslovListe").nextSibling);
        }
        alert("Prijava je uspješno napravljena!");
        await navigateTo('/');
    }
    else(alert(this.ErrorCode));}
  },

    provjeraUnosa(){
      let i = 1;
      let Unosi = Array.from(document.getElementsByTagName('input')).slice(1);
      Unosi.forEach((polje)=>{
        if(polje.value == ""){i = 0;
          this.ErrorCode = "Niste unijeli sve podatke!"
        }
      });
      if(document.getElementById("DatPoc").value > document.getElementById("DatKraj").value){
        console.log(document.getElementById("DatPoc").value +">"+document.getElementById("DatKraj").value);
        this.ErrorCode = "Datum završetka ne smije biti prije datuma početka!"
        return 0;
      }
      if(document.getElementById("DatPrij").value > document.getElementById("DatKraj").value){
        console.log(document.getElementById("DatPrij").value +">"+document.getElementById("DatKraj").value);
        this.ErrorCode = "Krajnji rok za prijavu ne smije biti nakon datuma završetka prijave!"
        return 0;
      }

      return i;
    },

    unesiPitanje(obj){
      if(obj.id == "buttoni") return 0;
      else{
        if(obj.childNodes[1].value == "KratkiOdgovor"){
          axios.post('http://localhost:8000/pitanjaRadionice', {
            "VrstaPodatka": "KratkiOdgovor",
            "radionice": this.Radionice,
            "NazivPitanja": obj.childNodes[0].value,
            "OpcijePitanja": "KratkiOdgovor",
          })
        }
        else if(obj.childNodes[1].value == "ViseTocnih"){
          let opcije = "";
          opcije += obj.childNodes[3].childNodes[1].value;
          Array.from(obj.childNodes).slice(4).forEach((dijete) => {
            opcije += (";" + dijete.childNodes[1].value);
          });
          axios.post('http://localhost:8000/pitanjaRadionice', {
            "VrstaPodatka": "ViseTocnih",
            "radionice": this.Radionice,
            "NazivPitanja": obj.childNodes[0].value,
            "OpcijePitanja": opcije,
          })
        }
        else if(obj.childNodes[1].value == "JedanOd"){
          let opcije = "";
          opcije += obj.childNodes[3].childNodes[1].value;
          Array.from(obj.childNodes).slice(4).forEach((dijete) => {
            opcije += (";" + dijete.childNodes[1].value);
          });
          axios.post('http://localhost:8000/pitanjaRadionice', {
            "VrstaPodatka": "JedanOd",
            "radionice": this.Radionice,
            "NazivPitanja": obj.childNodes[0].value,
            "OpcijePitanja": opcije,
          })
        }
      }
      return this.unesiPitanje(obj.nextSibling);
    }
}
}
</script>

<style scoped>
.hero {
  height: 100vh;
  background-color: white;
  text-align: center;
}



.Closer {
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

.Closer:hover {
  background-color: #080f18;
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

.btn-div {
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-div button {
  text-align: center;
}

.VrstePitanja {
  border: 1px solid white;
  border-radius: 8px;
  height: 3.6vh;
  padding: 5px 10px;
  background-color: transparent;
  transition: all 0.3s ease;
  color: white;
}

option {
  background: #014479;
}

.dugiteksti {
  flex-grow: 1;
  min-width: 200px;
  padding: 5px 10px;
  border: none;
  border-bottom: 1px solid white;
  background-color: transparent;
  transition: all 0.3s ease;
  color: white;
}

#Radionica {
  background-color: #014479;
  width: 70%;
  max-width: 1000px;
  margin: 0 auto;
  text-align: left;
  padding: 20px;
  line-height: 4vh;
  font-size: 2vh;
}

input[type="text"],
input[type="date"],
input[type="datetime-local"] {
  width: calc(100% - 20px);
  padding: 10px;
  margin: 10px 0;
  border: none;
  border-bottom: 1px solid white;
  background-color: transparent;
  transition: all 0.3s ease;
  color: white;
}

input[type='text']::placeholder {
  color: white;
}

.vise-tocnih {
  width: calc(100% - 20px);
  padding: 10px;
  margin: 10px 0;
  border: none;
  border-bottom: 1px solid white;
  background-color: transparent;
  transition: all 0.3s ease;
  color: white;
}

.hero-content {
  max-width: 1500px;
  margin: 0 auto;
}

.hero h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 40px;
}

.button-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.hero-button {
  background-color: rgba(16, 29, 47, 0.83);
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 0 10px;
  font-size: 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.hero-button:hover {
  background-color: rgba(16, 28, 44, 0.9);
}

.cards-container {
  position: relative;
}

.arrow-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: transparent;
  border: none;
  color: #000;
  font-size: 20px;
  cursor: pointer;
}

.arrow-button.left {
  left: 10px;
}

.arrow-button.right {
  right: 10px;
}

.cards-wrapper {
  overflow: hidden;
}

.cards {
  display: flex;
  transition: transform 0.3s ease;
}

.card {
  flex: 0 0 auto;
  width: 300px;
  margin-right: 20px;
}

.card img {
  width: 100%;
}

#Radionica input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
  opacity: 1;
  cursor: pointer;
}

#Radionica input[type="datetime-local"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
  opacity: 1;
  cursor: pointer;
}
</style>