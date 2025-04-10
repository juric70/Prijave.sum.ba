<template>
  <section class="forma">
    <div class="hero-content">
      <form id="Radionica" @submit.prevent="prijaviSe">
        <div class="dio2">
          <p id="NazivRadionice"><h1 id="Naziv"></h1></p>
        </div>
        <div class="dio">
          <p id="OpisRadionice"><h3 id="Opis"></h3></p>
        </div>

        <div class="dio" id="listaPitanja" v-for="(item, index) in pirjac" :key="index">
            <div v-if="item.VrstaPodatka === 'KratkiOdgovor'">
              <br/>
              <h3>{{ item.NazivPitanja }}</h3>
              <br/>
              <textarea v-model="item.odgovor" :placeholder="item.NazivPitanja" cols="60"></textarea>
            </div>
            <div v-else-if="item.VrstaPodatka === 'JedanOd'">
              <br/>
              <h3>{{ item.NazivPitanja }}</h3>
              <div v-for="(option, index) in item.OpcijePitanja.split(';')" :key="index">
                <br/>
                <input type="radio" :value="option" v-model="item.odgovor"  id="{{option}}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="{{option}}">{{ option }}</label>
              </div>
            </div>
            <div v-else-if="item.VrstaPodatka === 'ViseTocnih'">
              <br/>
              <h3>{{ item.NazivPitanja }}</h3>
              <div v-for="(option, index) in item.OpcijePitanja.split(';')" :key="index">
                <br/>
                <input type="checkbox" :value="option" v-model="item.odgovor"  id="{{option}}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="{{option}}">{{ option }}</label>
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
      try{
    let {data} = await axios.get("http://localhost:8000/api/user");
    this.user = data.id;
  }
  catch(error){console.log(error);
    if(error.response.status == 401){
      prijavaFailed.value = true;
    }
  }

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
          this.pirjac.forEach(item => {
            if(item.VrstaPodatka != "ViseTocnih")
            {
            item.odgovor = "";}
            else{
              item.odgovor=[];
            }

          });
        });
      } catch (error) {
        this.error = error.response ? error.response.data : error.message;
      }
    },

    async prijaviSe() {
      try {
        const response = await axios.post("http://localhost:8000/ListaPrijava", {
          "IdKreatora": this.user, 
          "IdRadionice": this.$route.query.id
        });
        this.brojPrijave = response.data;
        this.pirjac.forEach(item => {
          console.log(item)
          this.unesiPodatak(item);
        });

      } catch (error) {
        console.error(error);
      }
    },

    async unesiPodatak(bola) {
      let radi_molim_te="";
      if(bola.VrstaPodatka=="ViseTocnih")
        bola.odgovor.forEach(jao=>{radi_molim_te+=jao+";"}) 
      else
      radi_molim_te=bola.odgovor;
      try {
        console.error(bola);
        await axios.post("http://localhost:8000/KorisnikPodatak", {
          "IdPrijave": this.brojPrijave,
          "Odgovor": radi_molim_te,
        });
      } catch (error) {
        console.log(error);
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
  background: transparent;
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
  color: white;
  margin-top: 10px;
  text-align: center;
}

h3 {
  text-align: center;
  font-size: 24px;
  margin-bottom: 15px;
}

#listaPitanja {
  font-size: 20px;
  color:white;
  margin-top: 30px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
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

