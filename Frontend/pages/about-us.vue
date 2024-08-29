<script setup lang="ts">
</script>

<template>
    <div>
        <Header></Header>
        <div class="about-us-container">
      <h1>O nama</h1>
      <p>
        Centar za informacijske tehnologije Sveučilišta u Mostaru - SUMIT osnovan je 13. prosinca 2017. godine u cilju pružanja podrške obrazovnoj i akademskoj zajednici u upotrebi informacijsko-komunikacijskih tehnologija i osiguranja pristupa novim tehnologija i informacijskim uslugama. U ispunjavanju misije i vizije SUMIT-a od velikog su značaja partnerske institucije s kojima Sveučilište u Mostaru ima dugogodišnju suradnju. Tu prije svega držimo važnom suradnju s HT Eronet Mostar, Hrvatskom akademskom i istraživačkom mrežom - CARNET, Sveučilišnim računskim centrom (SRCE) i fakultetima koji se bave problematikom razvojem informacijskih sustava. Također je važna suradnja i sa lokalnim, pouzdanim IT tvrtkama.
      </p>
      <p>
        Na trećoj klauzuri Sveučilišta u Mostaru održanoj 29. svibnja 2018. godine donesen je zaključak da će Sveučilište sa strateškim partnerima stvoriti IT centar za cijelu vertikalu obrazovanja, a kada kažemo vertikalu, mislimo od vrtića do sveučilišta.
      </p>
      <p>
        Nakon klauzure Sveučilište u Mostaru napravilo je plan digitalizacije škola, projekt kojim će se učinkovitije i transparentnije upravljati školama te je uz pomoć strateških partnera omogućilo Maticu, odnosno digitalni oblik matične knjige, Dnevnik, elektronički identitet učenika i nastavnika, sustav za e-učenje Školarac a najvažnije napraviti sustavno obrazovanje svih korisnika sustava.
      </p>
      <p>
        Ovaj plan je podržan od Hrvatskog narodnog sabora koji je dana 11. veljače 2020. donio Odluku da sve škole koje nastavne planove i programe izvode na hrvatskom jeziku započnu proces digitalne transformacije obrazovanja u suradnji sa Centrom za informacijske tehnologije Sveučilišta u Mostaru - SUMIT.
      </p>
      <p>
        Centar za informacijske tehnologije Sveučilišta u Mostaru (SUMIT), organizacijski i tehnički, uspješno je odgovorio na pandemiju COVID-19 te su osigurani tehnički uvjeti za održavanje nastave na daljinu kako na Sveučilištu, tako i u školama u kojima se nastavni planovi i programi izvode na hrvatskom jeziku. Koordinacija ministara obrazovanja, znanosti, kulture i športa županija u kojima se nastavni planovi i programi izvode na hrvatskom jeziku u suradnji sa Sveučilištem u Mostaru je u svega nekoliko dana promijenila sustav održavanja nastave.
      </p>
      <p>
        Trenutno SUMIT održava veliki broj informacijskih sustava SUM-a te radi na digitalizaciji cijele vertikale obrazovanja i osiguravanju prostornih uvjeta u kampusu u Rodoču.
      </p>
      <p>
        SUMIT-a sebe vidi kao lidera u digitalnoj transformaciji obrazovanja, kao i društva općenito.
      </p>
      <p class="quote">
        "It always seems impossible until it's done."
      </p>
    </div>
        <Footer></Footer>
    </div>
</template>

<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default{
  mounted(){
    this.generirajHeader();
  },
  methods: {
    async generirajHeader(){
        try{
          let{data} = await axios.get("http://localhost:8000/api/user");
          this.napraviHeader(data);
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
          document.getElementsByClassName("mobile-menu")[0].innerHTML += "<a href='/login' class='mobile-nav-item' data-v-a81738bd>Odjavi se</a>";
          
        }
      }
  }
}

</script>

<style scoped>
.about-us-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  color: #333;
  text-align: left;
}

.about-us-container h1 {
  color: #014479;
  margin-bottom: 20px;
}

.about-us-container p {
  line-height: 1.6;
  margin-bottom: 20px;
}

.about-us-container .quote {
  font-style: italic;
  text-align: center;
  margin-top: 30px;
  color: #014479;
}
</style>