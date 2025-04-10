<template>
  <section class="forma">
    <div class="hero-content">
      <form @submit.prevent="prijaviSe">
        <h1 style="color: white">{{ radionicaInfo.NazivRadionice }}</h1>
        <div class="dio">
          <h3>{{ radionicaInfo.OpisRadionice }}</h3>
        </div>
        <h1 style="color: white">Sudionici</h1>
        <div class="table-responsive">
          <table class="lista-tablica">
            <thead>
            <tr>
              <th>Ime i prezime</th>
              <th class="email">Email</th>
              <th>Datum</th>
              <th>Akcija</th>
            </tr>
            </thead>
            <tbody class="tabela">
            <tr v-for="(prijava, index) in prijave" :key="index">
              <td>{{ prijava.imePrezime }}</td>
              <td class="email">{{ prijava.email }}</td>
              <td>{{ prijava.datum }}</td>
              <td>
                <button class="Buttoni" @click="pregledajPrijavu(prijava.id)">
                  >
                </button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials = true

export default {
  data() {
    return {
      user: null,
      radionicaInfo: {},
      prijave: []
    }
  },
  mounted() {
    this.ucitajRadionicu()
  },
  methods: {
    async ucitajRadionicu() {
      try {
        const { data } = await axios.get("http://localhost:8000/Radionica/" + this.$route.query.id)
        this.radionicaInfo = data
        // Ovdje dodati provjeru je li korisnik i kreator radionice, ne treba ako imamo route guard
        if (true) {
          this.ucitajPrijave()
        }
      } catch (error) {
        console.log(error.response ? error.response.data : error.message)
      }
    },
    async ucitajPrijave() {
      try {
        const { data } = await axios.get("http://localhost:8000/SvePrijave/" + this.$route.query.id)
        const temp = []
        for (let prijava of data) {
          try {
            let resUser = await axios.get("http://localhost:8000/prikaziKorisnika/" + prijava.IdKreatora)
            let userData = resUser.data
            temp.push({
              id: prijava.id,
              imePrezime: userData.name + " " + userData.lastname,
              email: userData.email,
              datum: new Date(userData.datumRodjenja).toLocaleDateString()
            })
          } catch (userError) {
            console.log(userError)
          }
        }
        this.prijave = temp
      } catch (error) {
        console.log(error)
      }
    },
    prijaviSe() {},
    pregledajPrijavu(id) {
      navigateTo("/prijava?id=" + id)
    },
  }
}
</script>

<style scoped>
.forma {
  min-height: 100vh;
  background-color: transparent;
  padding: 30px 0;
  text-align: center;
}
.hero-content {
  width: 80%;
  margin: 0 auto;
}
.dio {
  background-color: #014479;
  color: white;
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 20px;
}
.lista-tablica {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  color: #014479;
  border-radius: 8px;
  overflow: hidden;
}
.lista-tablica thead tr {
  background-color: #014479;
  color: white;
}
.lista-tablica th,
.lista-tablica td {
  text-align: left;
  padding: 10px;
  border: 1px solid #ddd;
}
.Buttoni {
  background-color: #014479;
  border-radius: 8px;
  padding: 10px 20px;
  margin: 0 auto;
  border: none;
  transition: all 0.3s ease;
  color: white;
  cursor: pointer;
  display: inline-block;
  text-align: center;
}
.Buttoni:hover {
  background-color: #080f18;
}
.table-responsive {
  overflow-x: auto;
}
@media (max-width: 600px) {
  .hero-content {
    width: 95%;
    padding: 0 5%;
  }
  
  .lista-tablica th,
  .lista-tablica td {
    font-size: 14px;
    padding: 8px;
  }
  .Buttoni {
    font-size: 14px;
    padding: 8px 16px;
  }
 .email {
  max-width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
 }
}
</style>