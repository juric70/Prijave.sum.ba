<template>
  <section class="forma">
    <div class="hero-content">
      <form id="Radionica" @submit.prevent="prijaviSe">
        <div class="dio2">
          <p id="NazivRadionice"><h1 id="Naziv"></h1> </p>
        </div>
        <div class="dio">
          <p id="OpisRadionice"><h3 id="Opis"></h3> </p>
        </div>

        <div class="dio" id="listaPitanja">
          <div v-for="(item, index) in pirjac" :key="index">
            <div v-if="item.VrstaPodatka === 'KratkiOdgovor'">
              <br/>
              <h3>{{ item.NazivPitanja }}</h3>
              <br/>
              <textarea cols="80"></textarea>
            </div>
            <div v-else-if="item.VrstaPodatka === 'JedanOd'">
              <br/>
              <h3>{{ item.NazivPitanja }}<br/></h3>
              <div v-for="(option, index) in item.OpcijePitanja.split(';')" :key="index">
                <br/>
                <input type="radio" :value="option" v-model="item.odgovor" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ option }}
                <br/><br/>
              </div>
            </div>
            <div v-else="item.VrstaPodatka==='ViseTocnih'">
              <br/>
              <h3>{{ item.NazivPitanja }}</h3>
              <div v-for="(option,index) in item.OpcijePitanja.split(';')" :key="index">
                <br/>
                <input type="checkbox" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ option }}
                <br/><br/>
              </div>
            </div>
          </div> 
        </div>

        <button class="Buttoni">Prijavi se</button>
      </form>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  mounted() {
    this.getRadionica();
  },
  data() {
    return {
      user: [],
      brojPrijave: 0,
      pirjac: [],
    }
  },

  methods: {
    async getRadionica() {
      try {
        await axios.get("http://localhost:8000/Radionica/" + this.$route.query.id).then(res => {
          document.getElementById("Naziv").innerHTML = res.data.NazivRadionice;
          document.getElementById("Opis").innerHTML = res.data.OpisRadionice;
        });
      } catch (error) {
        this.error = error.response ? error.response.data : error.message;
      }
      
      try {
        await axios.get("http://localhost:8000/SvaPitanja/" + this.$route.query.id).then(res => {
          this.pirjac = res.data;
        });
      } catch (error) {
        this.error = error.response ? error.response.data : error.message;
      }
    },

    async prijaviSe() {
      try {
        console.log(this.user.id);
        console.log(this.$route.query.id);
        const response = await axios.post("http://localhost:8000/ListaPrijava", {
          "IdKreatora": "1",
          "IdRadionice": this.$route.query.id
        });
        this.brojPrijave = response.data;

        Array.from(document.getElementById("listaPitanja").childNodes).forEach(pitanje => {
          this.unesiPodatak(pitanje);
        });
      } catch (error) {
        console.error(error);
      }
    },

    unesiPodatak(pitanje) {
      if (pitanje.firstChild.id === "KratkiOdgovor") {
        try {
          axios.post("http://localhost:8000/KorisnikPodatak", {
            "IdPrijave": this.brojPrijave,
            "Odgovor": pitanje.childNodes[1].value
          });
        } catch (error) {
          console.log(error);
        }
      } else if (pitanje.firstChild.id === "JedanOd") {
        let odabrano = null;
        Array.from(pitanje.childNodes).forEach(child => {
          if (child.tagName === "INPUT" && child.type === "radio" && child.checked) {
            odabrano = child.value;
          }
        });

        if (selectedValue !== null) {
          try {
            axios.post("http://localhost:8000/KorisnikPodatak", {
              "IdPrijave": this.brojPrijave,
              "Odgovor": selectedValue
            });
          } catch (error) {
            console.log(error);
          }
        }
      } else if (pitanje.firstChild.id === "ViseTocnih") {
        let sela = [];
        Array.from(pitanje.childNodes).forEach(child => {
          if (child.tagName === "INPUT" && child.type === "checkbox" && child.checked) {
            sela.push(child.value);
          }
        });

        if (selectedValues.length > 0) {
          try {
            axios.post("http://localhost:8000/KorisnikPodatak", {
              "IdPrijave": this.brojPrijave,
              "Odgovor": selectedValues.join(";")
            });
          } catch (error) {
            console.log(error);
          }
        } else {
          console.log("Nije dobro");
        }
      }
    }
  }
}
</script>

<style scoped>
.hero-content {
  width: 100%;
  height: 100%;
  padding: 20px;
}

.forma {
  width: 80%;
  max-width: 1000px;
  height: 100%;
  background: #094776;
  border-radius: 12px;
  padding: 30px;
  margin: 5% auto auto auto;
}

.dio2 {
  font-size: 50px;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
  background: none;
}

#Naziv {
  font-size: 60px;
  font-weight: bold;
  color: white;
  background: none;
}

#Opis {
  font-size: 40px;
  color: #666;
  margin-top: 10px;
  text-align: center;
}

h3 {
  text-align: center;
  font-size: 24px;
  margin-bottom: 15px;
}

#listaPitanja {
  font-size: 30px;
  color: black;
  margin-top: 30px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

input[type="radio"],
input[type="checkbox"] {
  margin-top: 10px;
  margin-right: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 18px;
  width: auto;
  color: #333;
}

textarea {
  display: block;
  margin: 0 auto;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 18px;
  color: #333;
  resize: none;
  min-height: 100px;
}

.Buttoni {
  background-color: #101D2F;
  border-radius: 8px;
  padding: 12px 25px;
  margin: 20px 0;
  border: none;
  color: white;
  text-align: center;
  font-size: 18px;
  width: 100%;
  height: auto;
}

@media screen and (max-width: 768px) {
  .forma {
    width: 90%;
    padding: 20px;
  }

  #Naziv {
    font-size: 45px;
  }

  #Opis {
    font-size: 35px;
  }

  #listaPitanja {
    font-size: 25px;
  }

  .Buttoni {
    font-size: 18px;
  }

  textarea {
    width: 90%;
  }
}

@media screen and (max-width: 480px) {
  .forma {
    width: 95%;
    padding: 15px;
  }

  #Naziv {
    font-size: 35px;
  }

  #Opis {
    font-size: 28px;
  }

  h3 {
    font-size: 20px;
  }

  #listaPitanja {
    font-size: 22px;
  }

  .Buttoni {
    font-size: 16px;
  }

  textarea {
    width: 95%;
  }
}
</style>
