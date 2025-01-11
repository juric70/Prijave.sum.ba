<template>
    <footer class="footer">
      <div class="footer-section left">
        <p>
          Udruga Switch <br>
          Matice hrvatske bb <br>
          88000 Mostar <br>
          Bosna i Hercegovina
        </p>
        <p>
          <MailIcon class="icon" /> switch@sum.ba
        </p>
        <p>
          <PhoneIcon class="icon" /> +387 63 939 998
        </p>
      </div>
      <div class="footer-section middle">
        <hr class="hr">
        <p>2024 — All rights reserved © <a href="https://sumit.sum.ba/" target="_blank" class="sumit-link">SUMIT</a></p>
      </div>
      <div class="footer-section right social-media">
        <img src="/public/sumit-Photoroom.png" alt="SUMIT icon" class="large" />
        <p>Follow us on social media:</p>
        <div class="icons">
          <a href="https://www.instagram.com/sumit.sum.ba/" target="_blank" class="sumit-link"><InstagramIcon class="icon2" /></a>
          <a href="https://www.facebook.com/sumit.sum.ba/" target="_blank" class="sumit-link"><FacebookIcon class="icon2" /></a>
          <a href="https://www.linkedin.com/company/center-for-information-technologies-sumit/?originalSubdomain=ba" target="_blank" class="sumit-link"><LinkedinIcon class="icon2" /></a>
        </div>
      </div>
    </footer>
  </template>
  
  <script setup>
  import MailIcon from '~/assets/icons/mail.svg'
  import PhoneIcon from '~/assets/icons/phone.svg'
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
    background-color: #101D2F;
    color: white;
    padding: 20px;
    font-family: Arial, sans-serif;
  }
  
  .footer-section {
    flex: 1;
    min-width: 250px;
    margin: 10px;
    text-align: left;
  }
  
  .hr {
    width: 60%;
    border: 1px solid white;
  }
  
  .footer-section p {
    margin: 5px 0;
  }
  
  .middle {
    text-align: center;
    flex: 1;
    margin-top: 150px;
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
    margin-right: 30px;
  }
  
  .sumit-link {
    color: white;
    text-decoration: none;
    text-decoration: underline;
  }
  
  @media (max-width: 768px) {
    .footer {
      flex-direction: column;
      align-items: center;
    }
  
    .footer-section {
      text-align: center;
      margin: 10px 0;
    }
  
    .middle {
      margin-top: 20px;
    }
  
    .right {
      align-items: center;
      text-align: center;
    }
  
    .social-media {
      align-items: center;
    }
  }
  </style>
  