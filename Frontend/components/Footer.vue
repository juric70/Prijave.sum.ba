<template>
    <footer class="footer">
      <div class="citav">
      <div class="footer-section left">
      <div class="leftphoto">
        <p>
       <img src="/photo6.png" alt="logo" class="logo" />
       </p>
      </div>
        <p>
         <br> 
          University of Mostar <br>
          Switch <br>
           <br>
          Matice hrvatske bb, <br>
          88000 Mostar, <br> 
          Bosna i Hercegovina
        </p>
     </div>
      <div class="footer-section right social-media">
        <p>
        Email: udrugaswitch@gmail.com
        </p>
        <p>
        Phone: +387 (63) 939 998
        </p>
        <p>
        Fax: +387 (36) 337-001
        </p>
        <p>FOLLOW US ON <br> SOCIAL NETWORKS</p>
        <div class="icons">
          <a href="https://www.instagram.com/sumit.sum.ba/" target="_blank" class="sumit-link"><InstagramIcon class="icon2" /></a>
          <a href="https://www.facebook.com/sumit.sum.ba/" target="_blank" class="sumit-link"><FacebookIcon class="icon2" /></a>
          <a href="https://www.linkedin.com/company/center-for-information-technologies-sumit/?originalSubdomain=ba" target="_blank" class="sumit-link"><LinkedinIcon class="icon2" /></a>
        </div>
      </div>
    </div>
  </footer>
  <div class="horizontal-line">
      <hr class="hr">
      <br>
      <p class="text">Switch</p>
  </div>
  </template>
  
  <script setup>
  import InstagramIcon from '~/assets/icons/instagram.svg'
  import FacebookIcon from '~/assets/icons/facebook.svg'
  import LinkedinIcon from '~/assets/icons/linkedin.svg'
  </script>
  
  <style scoped>
  .footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    color: white;
    padding: 20px;
    margin-bottom: 0%;
    font-family: Arial, sans-serif;
  }
  .citav{
    display: flex;
    flex-wrap: wrap;
    align-self: center;
    width: 95%;
    margin-left: 2.5%;
    justify-content: space-between;
    align-items: flex-start;
  }
  
  .footer-section {
    display: flex;
    flex: 1;
    margin-left: 10px;
    max-width: 50%;
    text-align: left;
  }

  .leftphoto{
    margin-right: 30px;
  }
  
  .horizontal-line{
    width: 100%;
    flex: 1;
    align-self: center;
    margin-bottom: 20px;
    text-align: center;
  }
  .hr {
    width: 95%;
    border: 1px solid white;
    flex: 1;
    margin-left: 2.5%;
    align-self: flex-end;
    text-align: center;
    margin-top: 10px;
  }
  
  .footer-section p {
    margin: 5px 0;
  }
  
  .right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    text-align: right;
  }
  
  .icon {
    width: 20px;
    height: 20px;
    margin-right: 10px;
  }
  
  .icon2 {
    width: 20px;
    height: 20px;
    margin: 10px;
  }
  
  .large {
    width: 200px;
    height: 110px;
  }
  
  .social-media {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
  }
  
  .social-media p {
    margin: 10px 0;
  }
  
  .icons {
    display: flex;
    margin-right: 10px;
  }
  
  .sumit-link {
    color: white;
    text-decoration: none;
    text-align: center;
  }

  .text{
    align-self: flex-end;
    align-content: center;
  }

  
  @media (max-width: 768px) {
    .footer {
      flex-direction: column;
      justify-content: space-between;
    }

    .left{
      display: table-row;
      flex: 1;
      align-self: left;
    }
  
    .footer-section {
      text-align: left;
      margin: 10px 0;
    }

    .social-media {
    align-items: right;
    margin-right: 2%;
  }
  
    .social-media p {
      margin-top: 1%;
      align-self: flex-end;
    }
  
    .icons {
      margin-right: 0px;
    }
    .right {
      align-items: right;
      text-align: right;
      max-width: 50%;
      font-size: small;
      margin-bottom: 0%;
      margin-top: 40%;
      margin-right: 0%;
    }
  
    .social-media {
      align-items: center;
    }
  }
  </style>
  