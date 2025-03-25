
<script>
import axios from 'axios';
import Tablica from './Tablica.vue';
axios.defaults.withCredentials = true;
export default {
  mounted(){
    this.getRadionica();
  },
  data(){
    return{
      user: [],
      brojPrijave: 0,
      MojaPitanja: [],
      MojiOdgovori: [],
      brojRadionice: 0,
      brojKorisnika: 0,
      pirjac:[]
    }
  },

  methods: {
    async getRadionica(){
      try{
          await axios.get("http://localhost:8000/ListaPrijava/"+this.$route.query.id).then(res =>{
              this.brojRadionice = res.data.IdRadionice;
              this.brojKorisnika = res.data.IdKreatora;
          })
      }catch(error){console.log(error);}
    try {
      await axios.get("http://localhost:8000/User/"+this.brojKorisnika).then(res=>{
          
              document.getElementById('ime').innerHTML=res.data.name+" "+res.data.lastname;
            }
          )
    } catch (error) {
      console.log(error);
    }
      try {
          await axios.get("http://localhost:8000/Radionica/" + this.brojRadionice).then(res =>{
            document.getElementById("Naziv").innerHTML = res.data.NazivRadionice;
            document.getElementById("Opis").innerHTML = res.data.OpisRadionice;
          })
        } catch (error) {
          this.error = error.response ? error.response.data : error.message
        }
  
        try {
await axios.get("http://localhost:8000/SvaPitanja/" + this.brojRadionice).then(res => {
  res.data.forEach(pitanje => {
    let mili=pitanje.NazivPitanja;
    let rec="";
    //let red = document.createElement("tr");
    //red.classList.add("ajmo");
    //let pita = document.createElement("td");
//red.style.border= "5px solid #094776";
//red.style.padding = "5px";
//red.style.borderRadius = "25px";
//red.id="milica";
//pita.style.color = "#094776";
//pita.style.width="50%";
//red.classList.add('mars');
//red.style.marginBottom = '10px';
//pita.innerHTML = "<b>" + pitanje.NazivPitanja + "</b>";
    axios.get("http://localhost:8000/SviPodaci/" + this.brojKorisnika).then(resp => {
      //let oda = document.createElement("td");
      resp.data.forEach((pitanjeOdgovor, index) => {
       if (index == res.data.indexOf(pitanje)) {
          if(pitanje.VrstaPodatka=="ViseTocnih"){
            let niz =pitanjeOdgovor.Odgovor.split(";");
            niz.forEach((lola)=>{rec+=lola+"\n"});
            //oda.innerHTML="<b data-v-49ee08f9>"+rec+"</b>";
          }
          else{
            rec =pitanjeOdgovor.Odgovor;
          //oda.innerHTML = "<b>" + text + "</b>";
          } 
          //red.appendChild(pita);
          //red.appendChild(oda);
          }
      });
     // document.getElementById("tijelo1").appendChild(red);
      /*oda.style.color = "black";
      oda.style.width="50% ";
      pita.style.color = "#094776";
      pita.style.width="50%";
      red.style.border= "5px solid #094776";
      red.style.borderRadius="25px";
      pita.style.color="#094776";*/
      console.log(mili);
      console.log(rec);
      this.pirjac.push({pitanja:mili,odgovor:rec});
  
    }).catch(error => console.log(error));
  });
}).catch(error => console.log(error));
} catch (error) {
this.error = error.response ? error.response.data : error.message;
}

    },
    ispisiPitanje(pitanje){
      let pom = document.getElementById("listaPitanja");
      if(pitanje.VrstaPodatka == "KratkiOdgovor"){
        pom.appendChild(document.createElement("th"));
        pom.lastChild.innerHTML="<h3 id='KratkiOdgovor'> " + pitanje.NazivPitanja + " <br/></h3><textarea id='odgovor':class='{'textarea-custom-width':true,'h-auto':true}'@input='adjustHeight'class='resize-none overflow-hidden p-2 border rounded-md shadow-sm focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50'></textarea>";
        pom.lastChild.childNodes[1].style.width = '50%';
      }
      else if(pitanje.VrstaPodatka == "ViseTocnih"){
        pom.appendChild(document.createElement("th"));
        let popisPitanja = pitanje.OpcijePitanja.split(";");
        let stringOpcija = "<h3 id='ViseTocnih'>" + pitanje.NazivPitanja + "</h3>";
        popisPitanja.forEach((opcija) => {
          stringOpcija += "<input type='checkbox' name='option" + pitanje.id + "' value='" + opcija + "'><label for='option" + pitanje.id + "'>" + opcija + "</label><br/>"
        })
        pom.lastChild.innerHTML = stringOpcija;
      }
      else if(pitanje.VrstaPodatka == "JedanOd"){
        pom.appendChild(document.createElement("th"));
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
   
    Array.from(pitanje.childNodes).forEach(child => {
      if (child.tagName === "INPUT" && child.type === "checkbox" && child.checked) {
        selectedValues.push(child.value);
      }
    });

    if (selectedValues.length > 0) {
      try {
        axios.post("http://localhost:8000/KorisnikPodatak", {
          "IdPrijave": this.brojPrijave,
          "Odgovor": selectedValues.join(";"), 
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
<template>
  <body>
  <section class="forma">
    <div class="hero-content">
      <form id="Radionica" @submit.prevent="prijaviSe">
        <div id="prva">
          <h1>Sudionik</h1>
        </div>
        <div class="dio2">
        <p id="ime1"><h3 id="ime"></h3></p>
         <p id="NazivRadionice"><h1 id="Naziv"></h1> </p>
         <p id="OpisRadionice"><h3 id="Opis"></h3> </p>
        </div>
        
        <div id="prva">
          <h1>Upitnik</h1>
        </div>
        <Tablica :pila="pirjac"/>
      </form>
    </div>
  </section>
</body>
</template>



<style scoped>
.forma {
  height: 100%;
  width: 100%;
  text-align: center;
  margin:0;
}
body{
  background-image: linear-gradient(to top right, #3a3c60, #423b60,#54395a,#673554,#7d334d,#8c344c,#ac3043,#b72e40,#c12f3f);
  background-position: center center;
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}
.hero-content {
  max-width: 800px;
}
#Radionica {
  width: 60vw;
  position: relative;
  left: 20vw;
  top: 5vw;
  text-align: left;
  line-height: 4vh;
  font-size: 2vh;
  border-radius: 16px;
}

#ajmo{
  width:100%;
  height: auto;
}

.dio {
  margin-top: auto;
  height: 10vh;
  color: black;
  width: 100%;
}

.dio2 {
 
  border-radius: 10px;
  height: 18vh;
  background-color: white;
  padding-left: 2rem;
  padding-top: 2rem;
  padding-bottom: 2rem;
  color:#094776;
  border: 3px solid #094776;
  overflow:hidden;
}

.textarea-custom-width {
  width: 50%;
}

.Buttoni {
  background-color: #101D2F;
  border-radius: 8px;
  padding: 10px 20px;
  margin: 20px 0px;
  border: none;
  transition: all 0.3s ease;
  color: white;
  cursor: pointer;
  text-align: center;
}

.Buttoni:hover {
  background-color: #080f18;
}

#prva {
  
  color:white;
  width: 100%;
  height: 5vh;
  margin-top: 1.5rem;
  margin-bottom: none;
}
#pita {
  width: 70%;
  text-align: left;
  background-color: #094776;
  color: white;
  border-top-left-radius: 8px;
  border-end-start-radius: 8px;
}

#odg {
  width: 30%;
  text-align: left;
  background-color: #094776;
  color: white;
  border-top-right-radius: 8px;
  border-end-end-radius: 8px;
}

#mars {
    background-color: white;
    color: #094776;
    margin: auto;
    width: 100%;
    white-space: normal;
    word-wrap: break-word;
}
#marsa{
  color: red;
}
#mars1 {
    text-align: right;
    margin-left: 10rem;
    border-radius: 30px;
    border-color: #094776;
    color: #094776;
    white-space: normal;
    word-wrap: break-word;
}

textarea {
    width: 100%;
    resize: vertical;
    overflow-y: auto;
}

th, td {
    word-wrap: break-word;
    white-space: normal;
    overflow: hidden;
}

.textarea-custom-width {
    width: 100%;
    max-width: 100%;
}



#glava {
background-color: #094776;
color: white;
height: 5vh;
border-spacing: 0;
border: none;
}


table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

th{
  padding: 10px;
  text-align: left;
  border: none;
}

.dio {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {
  #Radionica {
    width: 90vw;
    left: 5vw;
    font-size: 3vh;
  }

  .dio2 {
    padding: 5rem;
    overflow: auto;
  }

  table {
    width: 100%;
  }

  #pita {
    width: 100%; 
  }

  #odg {
    width: 100%;
  }
  h1,
  h3 {
    font-size: 3vh;
  }
}
</style>