<script setup lang="ts">
</script>

<template>
    <div>
        <div class="about-us-container">
      <h1 style="font-size: 2rem; margin-bottom: 30px;">O nama</h1>
      <div class="about-us-header">
        <img src="../assets/sumit_transparent.svg" alt="SUMIT Logo" class="logo" >
        <p>
          Centar za informacijske tehnologije Sveučilišta u Mostaru - SUMIT osnovan je 13. prosinca 2017. godine u cilju pružanja podrške obrazovnoj i akademskoj zajednici u upotrebi informacijsko-komunikacijskih tehnologija i osiguranja pristupa novim tehnologijama i informacijskim uslugama. U ispunjavanju misije i vizije SUMIT-a od velikog su značaja partnerske institucije s kojima Sveučilište u Mostaru ima dugogodišnju suradnju. Tu prije svega držimo važnom suradnju s HT Eronet Mostar, Hrvatskom akademskom i istraživačkom mrežom - CARNET, Sveučilišnim računskim centrom (SRCE) i fakultetima koji se bave problematikom razvoja informacijskih sustava. Također je važna suradnja i s lokalnim, pouzdanim IT tvrtkama.
        </p>
      </div>
      <p>
        Na trećoj klauzuri Sveučilišta u Mostaru održanoj 29. svibnja 2018. godine donesen je zaključak da će Sveučilište sa strateškim partnerima stvoriti IT centar za cijelu vertikalu obrazovanja, a kada kažemo vertikalu, mislimo od vrtića do sveučilišta.
      </p>
      <p>
        Nakon klauzure Sveučilište u Mostaru napravilo je plan digitalizacije škola, projekt kojim će se učinkovitije i transparentnije upravljati školama, a najvažnije, napraviti sustavno obrazovanje svih korisnika sustava. Uz pomoć strateških partnera omogućilo je Maticu, odnosno digitalni oblik matične knjige, Dnevnik, elektronički identitet učenika i nastavnika te sustav za e-učenje Školarac.
      </p>
      <p>
        Ovaj plan je podržan od Hrvatskog narodnog sabora koji je dana 11. veljače 2020. donio odluku da sve škole koje nastavne planove i programe izvode na hrvatskom jeziku započnu proces digitalne transformacije obrazovanja u suradnji s Centrom za informacijske tehnologije Sveučilišta u Mostaru - SUMIT.
      </p>
      <p>
        Centar za informacijske tehnologije Sveučilišta u Mostaru (SUMIT), organizacijski i tehnički, uspješno je odgovorio na pandemiju COVID-19 te su osigurani tehnički uvjeti za održavanje nastave na daljinu, kako na Sveučilištu, tako i u školama u kojima se nastavni planovi i programi izvode na hrvatskom jeziku. Koordinacija ministara obrazovanja, znanosti, kulture i športa županija u kojima se nastavni planovi i programi izvode na hrvatskom jeziku u suradnji sa Sveučilištem u Mostaru je u svega nekoliko dana promijenila sustav održavanja nastave.
      </p>
      <p>
        Trenutačno SUMIT održava veliki broj informacijskih sustava SUM-a te radi na digitalizaciji cijele vertikale obrazovanja i osiguravanju prostornih uvjeta u kampusu u Rodoču.
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

</script>

<style scoped>
.about-us-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  color: #ffffff;
  text-align: left;
  text-align: justify;
}

.about-us-container h1 {
  color: #ffffff;
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
.about-us-header{
  gap: 20px;
  margin-bottom: 20px;
}
.logo{
  float: left;
  width: 350px;
  height: auto;
  margin-right: 30px;
  margin-bottom: 30px;
}
</style>