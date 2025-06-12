<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import type User from "~/lib/types/User";

<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import type User from "~/lib/types/User";
import Tablica from './Tablica.vue';
import * as EXCEL from 'xlsx'

axios.defaults.withCredentials = true;

const route = useRoute();
const user = useSanctumUser().value as User;

const brojPrijave = ref(0);
const brojRadionice = ref(0);
const brojKorisnika = ref(0);
const pirjac = reactive<{ pitanja: string; odgovor: string }[]>([]);
const error = ref<string | null>(null);
const ime = ref("");

const ajmouexcel = () =>{
      const kora= pirjac.map(({ pitanja,odgovor}) => ({
        "Ime": ime.value,
        "Pitanje": pitanja,
        "Odgovor": odgovor,
      }))
      const radno = EXCEL.utils.json_to_sheet(kora)
      const knjiga = EXCEL.utils.book_new()
      EXCEL.utils.book_append_sheet(knjiga, radno)
      const imeFilea = 'excel.xlsx'
      EXCEL.writeFile(knjiga, imeFilea)
    }

const getRadionica = async () => {
  try {
    const prijavaRes = await axios.get(
      `http://localhost:8000/ListaPrijava/${route.query.id}`
    );
    brojRadionice.value = prijavaRes.data.IdRadionice;
    brojKorisnika.value = prijavaRes.data.IdKreatora;

    const userElement = document.getElementById("ime");
    try{
      const kreator = await axios.get(
        `http://localhost:8000/User/${brojKorisnika.value}`
      );
      console.log(brojKorisnika.value);
      console.log(kreator);
      if (userElement) {
        userElement.innerHTML = `${kreator.data.name} ${kreator.data.lastname}`;
        ime.value = `${kreator.data.name} ${kreator.data.lastname}`;
      }
    }catch(error){
        console.log(error);
      }

    const radionicaRes = await axios.get(
      `http://localhost:8000/Radionica/${brojRadionice.value}`
    );
    const nazivElement = document.getElementById("Naziv");
    const opisElement = document.getElementById("Opis");
    if (nazivElement) nazivElement.innerHTML = radionicaRes.data.NazivRadionice;
    if (opisElement) opisElement.innerHTML = radionicaRes.data.OpisRadionice;

    const pitanjaRes = await axios.get(
      `http://localhost:8000/SvaPitanja/${brojRadionice.value}`
    );
    for (const pitanje of pitanjaRes.data) {
      let odgovor = "";
      const korisnikRes = await axios.get(
        `http://localhost:8000/SviPodaci/${brojKorisnika.value}`
      );
      const odgovori = korisnikRes.data;

      const odgovarajuciOdgovor = odgovori.find(
        (odgovor: any, index: number) =>
          index === pitanjaRes.data.indexOf(pitanje)
      );

      if (odgovarajuciOdgovor) {
        if (pitanje.VrstaPodatka === "ViseTocnih") {
          odgovor = odgovarajuciOdgovor.Odgovor.split(";").join("\n");
        } else {
          odgovor = odgovarajuciOdgovor.Odgovor;
        }
      }

      pirjac.push({ pitanja: pitanje.NazivPitanja, odgovor });
    }
  } catch (err: any) {
    error.value = err.response ? err.response.data : err.message;
    console.error(err);
  }
};

const prijaviSe = async () => {
  try {
    const prijavaRes = await axios.post("http://localhost:8000/ListaPrijava", {
      IdKreatora: user.id,
      IdRadionice: route.query.id,
    });
    brojPrijave.value = prijavaRes.data;

    const listaPitanja = document.getElementById("listaPitanja");
    if (listaPitanja) {
      const pitanja = Array.from(listaPitanja.childNodes);
      for (const pitanje of pitanja) {
        unesiPodatak(pitanje as HTMLElement);
      }
    }
  } catch (err) {
    console.error(err);
  }
};

const unesiPodatak = async (pitanje: HTMLElement) => {
  const firstChild = pitanje.firstChild as HTMLElement | null;
  if (!firstChild) return;

  if (firstChild.id === "KratkiOdgovor") {
    const odgovor = (pitanje.querySelector("textarea") as HTMLTextAreaElement)
      ?.value;
    if (odgovor) {
      try {
        await axios.post("http://localhost:8000/KorisnikPodatak", {
          IdPrijave: brojPrijave.value,
          Odgovor: odgovor,
        });
      } catch (err) {
        console.error(err);
      }
    }
  } else if (firstChild.id === "JedanOd") {
    const selectedValue = (
      Array.from(
        pitanje.querySelectorAll("input[type='radio']")
      ) as HTMLInputElement[]
    ).find(input => input.checked)?.value;

    if (selectedValue) {
      try {
        await axios.post("http://localhost:8000/KorisnikPodatak", {
          IdPrijave: brojPrijave.value,
          Odgovor: selectedValue,
        });
      } catch (err) {
        console.error(err);
      }
    }
  } else if (firstChild.id === "ViseTocnih") {
    const selectedValues = (
      Array.from(
        pitanje.querySelectorAll("input[type='checkbox']")
      ) as HTMLInputElement[]
    )
      .filter(input => input.checked)
      .map(input => input.value);

    if (selectedValues.length > 0) {
      try {
        await axios.post("http://localhost:8000/KorisnikPodatak", {
          IdPrijave: brojPrijave.value,
          Odgovor: selectedValues.join(";"),
        });
      } catch (err) {
        console.error(err);
      }
    }
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
        <div id="prva">
          <h1>Sudionik</h1>
        </div>
        <div class="dio2">
          <h3 id="ime"></h3>
          <h1 id="Naziv"></h1>
          <h3 id="Opis"></h3>
        </div>
        <div id="prva">
          <h1>Upitnik</h1>
        </div>
        <Tablica :pila="pirjac"/>
        <button @click.prevent="ajmouexcel" class="buton">Prebaci u Excel</button>
      </form>
    </div>
  </section>
</template>

<style scoped>
.buton{
  background-color: #101D2F;
  border-radius: 8px;
  padding: 10px 20px;
  margin:  auto;
  margin-left: 45%;
  border: none;
  transition: all 0.3s ease;
  color: white;
  cursor: pointer;
  display: inline-block;
  text-align: center;

}
.forma {
  height: 100%;
  width: 100%;
  text-align: center;
  margin: 0;
}
body {
  background-image: linear-gradient(
    to top right,
    #3a3c60,
    #423b60,
    #54395a,
    #673554,
    #7d334d,
    #8c344c,
    #ac3043,
    #b72e40,
    #c12f3f
  );
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

#ajmo {
  width: 100%;
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
  color: #094776;
  border: 3px solid #094776;
  overflow: hidden;
}

.textarea-custom-width {
  width: 50%;
}

.Buttoni {
  background-color: #101d2f;
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
  color: white;
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
#marsa {
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

th,
td {
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

th {
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
.buton{
  margin-left: 15%;
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
