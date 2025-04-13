<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import type User from "~/lib/types/User";

axios.defaults.withCredentials = true;

const route = useRoute();
const user = useSanctumUser().value as User;

const brojPrijave = ref(0);
const pirjac = reactive<
  {
    NazivPitanja: string;
    VrstaPodatka: string;
    OpcijePitanja: string;
    odgovor: string | string[];
  }[]
>([]);
const error = ref<string | null>(null);

const getRadionica = async () => {
  try {
    const radionicaRes = await axios.get(
      `http://localhost:8000/Radionica/${route.query.id}`
    );
    const nazivElement = document.getElementById("Naziv");
    const opisElement = document.getElementById("Opis");
    if (nazivElement) nazivElement.innerHTML = radionicaRes.data.NazivRadionice;
    if (opisElement) opisElement.innerHTML = radionicaRes.data.OpisRadionice;
  } catch (err: any) {
    error.value = err.response ? err.response.data : err.message;
    console.error(err);
  }

  try {
    const pitanjaRes = await axios.get(
      `http://localhost:8000/SvaPitanja/${route.query.id}`
    );
    pirjac.splice(
      0,
      pirjac.length,
      ...pitanjaRes.data.map((item: any) => ({
        ...item,
        odgovor: item.VrstaPodatka === "ViseTocnih" ? [] : "",
      }))
    );
  } catch (err: any) {
    error.value = err.response ? err.response.data : err.message;
    console.error(err);
  }
};

const prijaviSe = async () => {
  try {
    const response = await axios.post("http://localhost:8000/ListaPrijava", {
      IdKreatora: user.id,
      IdRadionice: route.query.id,
    });
    brojPrijave.value = response.data;

    for (const item of pirjac) {
      await unesiPodatak(item);
    }
  } catch (err) {
    console.error(err);
  }
};

const unesiPodatak = async (item: {
  VrstaPodatka: string;
  odgovor: string | string[];
}) => {
  let odgovor = "";
  if (item.VrstaPodatka === "ViseTocnih") {
    odgovor = (item.odgovor as string[]).join(";");
  } else {
    odgovor = item.odgovor as string;
  }

  try {
    await axios.post("http://localhost:8000/KorisnikPodatak", {
      IdPrijave: brojPrijave.value,
      Odgovor: odgovor,
    });
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  getRadionica();
});
</script>

<template>
  <section class="forma">
    <div class="hero-content">
      <form
        id="Radionica"
        @submit.prevent="prijaviSe">
        <div class="dio2">
          <h1 id="Naziv"></h1>
        </div>
        <div class="dio">
          <h3 id="Opis"></h3>
        </div>

        <div
          class="dio"
          id="listaPitanja"
          v-for="(item, index) in pirjac"
          :key="index">
          <div v-if="item.VrstaPodatka === 'KratkiOdgovor'">
            <br />
            <h3>{{ item.NazivPitanja }}</h3>
            <br />
            <textarea
              v-model="item.odgovor"
              :placeholder="item.NazivPitanja"
              cols="60"></textarea>
          </div>
          <div v-else-if="item.VrstaPodatka === 'JedanOd'">
            <br />
            <h3>{{ item.NazivPitanja }}</h3>
            <div
              v-for="(option, index) in item.OpcijePitanja.split(';')"
              :key="index">
              <br />
              <input
                type="radio"
                :value="option"
                v-model="item.odgovor"
                :id="option" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label :for="option">{{ option }}</label>
            </div>
          </div>
          <div v-else-if="item.VrstaPodatka === 'ViseTocnih'">
            <br />
            <h3>{{ item.NazivPitanja }}</h3>
            <div
              v-for="(option, index) in item.OpcijePitanja.split(';')"
              :key="index">
              <br />
              <input
                type="checkbox"
                :value="option"
                v-model="item.odgovor"
                :id="option" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label :for="option">{{ option }}</label>
            </div>
          </div>
        </div>

        <button class="Buttoni">Prijavi se</button>
      </form>
    </div>
  </section>
</template>

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
  color: white;
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
  background-color: #101d2f;
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
